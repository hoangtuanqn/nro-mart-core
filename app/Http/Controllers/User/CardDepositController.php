<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\CardDeposit;
use App\Models\MoneyTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CardDepositController extends Controller
{
    public function __construct()
    {
        if (!config_get('payment.card.active', true)) {
            abort(403, 'Truy cập không hợp lệ!');
        }
    }

    /**
     * Process a card deposit request.
     */
    public function processCardDeposit(Request $request)
    {
        // Validate the request
        $request->validate([
            'telco' => 'required|string|in:VIETTEL,MOBIFONE,VINAPHONE,VIETNAMOBILE',
            'amount' => 'required|numeric|in:10000,20000,50000,100000,200000,500000',
            'serial' => 'required|string|min:5|max:20',
            'pin' => 'required|string|min:5|max:20'
        ]);
        // dd(123);


        if (CardDeposit::where('status', 'processing')->where('user_id', Auth::id())->count() >= 5) {
            return redirect()->route('profile.deposit-card')
                ->with('error', 'Bạn có quá nhiều thẻ đang chờ xử lý. Vui lòng đợi!')->withInput();
        }
        $partnerWeb = config_get('payment.card.partner_website');
        if (
            !in_array($partnerWeb, [
                'thesieure.com',
                'cardvip.vn',
                'doithe1s.vn'
            ])
        ) {
            return redirect()->route('profile.deposit-card')
                ->with('error', 'Website đối tác không hợp lệ!')->withInput();
        }
        try {
            $partner_id = config_get('payment.card.partner_id', '');
            $partner_key = config_get('payment.card.partner_key', '');
            $request_id = rand(111111111111, 9999999999999);
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post("https://$partnerWeb/chargingws/v2", [
                        'telco' => $request->telco,
                        'code' => $request->pin,
                        'serial' => $request->serial,
                        'amount' => $request->amount,
                        'request_id' => $request_id,
                        'partner_id' => $partner_id,
                        'sign' => md5($partner_key . $request->pin . $request->serial),
                        'command' => 'charging'
                    ]);
            if (!$response->successful()) {
                return redirect()->route('profile.deposit-card')
                    ->with('error', 'Không thể kết nối đến máy chủ. Vui lòng thử lại sau.');
            }
            $status = $response->json('status');
            if ($status === 3 || $status === 100) {
                return redirect()->route('profile.deposit-card')
                    ->with('error', 'Lỗi: ' . $response->json('message'))->withInput();
            }

            // Create a new card deposit record
            $deposit = new CardDeposit();
            $deposit->user_id = Auth::id();
            $deposit->telco = $request->telco;
            $deposit->amount = $request->amount;
            $deposit->received_amount = $request->amount; // No discount
            $deposit->serial = $request->serial;
            $deposit->pin = $request->pin;
            $deposit->request_id = $request_id;
            $deposit->status = 'processing'; // Initial status
            $deposit->save();

            return redirect()->route('profile.deposit-card')
                ->with('success', 'Thẻ của bạn đang được xử lý. Vui lòng đợi trong giây lát.');

        } catch (\Exception $e) {
            // Log::error('Card deposit error: ' . $e->getMessage());
            return redirect()->route('profile.deposit-card')
                ->with('error', 'Có lỗi xảy ra khi xử lý thẻ. Vui lòng thử lại sau.')->withInput();
        }
    }

    public function handleCallback(Request $request)
    {
        // Kiểm tra dữ liệu callback gửi về
        try {
            $validated = $request->validate([
                'status' => 'required|integer',
                'message' => 'nullable|string',
                'request_id' => 'required|string',
                'declared_value' => 'required|integer',
                'card_value' => 'required|integer',
                'value' => 'required|integer',
                'amount' => 'required|integer',
                'code' => 'required|string',
                'serial' => 'required|string',
                'telco' => 'required|string',
                'trans_id' => 'required|string',
                'callback_sign' => 'required|string',
            ]);
            // return response()->json($validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        }


        // Xác định trạng thái nạp thẻ dựa trên `status`
        $statusMapping = [
            1 => 'success',       // Thẻ thành công đúng mệnh giá
            2 => 'success',       // Thẻ thành công sai mệnh giá
            3 => 'error',         // Thẻ lỗi
            4 => 'error',         // Hệ thống bảo trì
            99 => 'processing',    // Thẻ chờ xử lý
            100 => 'error',         // Gửi thẻ thất bại
        ];

        $status = $statusMapping[$validated['status']] ?? 'error';
        // check mã partner key

        $cardDeposit = CardDeposit::with('user')->where('request_id', $validated['request_id'])->first();

        // Kiểm tra thẻ có tồn tại không
        if (!$cardDeposit) {
            return response()->json(['message' => 'Dữ liệu không hợp lệ'], 200);
        }

        // Kiểm tra thẻ đã được xử lý chưa
        if ($cardDeposit->status != 'processing') {
            return response()->json(['message' => 'Thẻ này đã được xử lý từ trước.'], 200);
        }

        // Kiểm tra user có tồn tại không
        if (!$cardDeposit->user) {
            return response()->json(['message' => 'Người dùng nạp thẻ không tồn tại.'], 404);
        }

        // Sử dụng transaction để đảm bảo tính toàn vẹn dữ liệu
        DB::beginTransaction();
        try {
            // Cập nhật thông tin nạp thẻ
            $amount = $validated['card_value'];
            if ($validated['status'] == 2) {
                $amount = $amount * 0.5; // Nhận 50% mệnh giá thực vì sai mệnh giá
            } else if ($validated['status'] == 1) {
                $amount = $amount - $amount * config_get('payment.card.discount_percent') / 100;
            }
            $cardDeposit->received_amount = $amount; // Mệnh giá thực của thẻ
            $cardDeposit->status = $status;
            $cardDeposit->response = json_encode($validated); // Lưu toàn bộ response
            $cardDeposit->save();

            // Nếu trạng thái là thành công, cộng tiền cho người dùng
            if ($status === 'success') {
                $user = $cardDeposit->user;
                $previousBalance = $user->balance;
                $user->balance += $amount;
                $user->save();

                // Thêm lịch sử biến động số dư
                MoneyTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'deposit',
                    'amount' => $amount,
                    'balance_before' => $previousBalance,
                    'balance_after' => $user->balance,
                    'description' => ($validated['status'] == 2 ? 'Sai mệnh giá nhận 50%. ' : '') . 'Nạp thẻ ' . $validated['telco'] . ' nhận được ' . number_format($amount) . 'đ',
                    'reference_id' => $cardDeposit->id
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Nhập dữ liệu và xử lý thành công!', 'data' => $cardDeposit]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Đã xảy ra lỗi: ' . $e->getMessage()], 500);
        }
    }

}