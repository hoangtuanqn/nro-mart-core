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
use App\Models\MoneyTransaction;
use App\Models\ServiceHistory;
use App\Models\ServicePackage;
use App\Models\GameService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiceOrderController extends Controller
{
    public function processOrder(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:game_services,id',
            'package_id' => 'required|exists:service_packages,id',
            'server' => 'required|integer|min:1|max:13',
            'game_account' => 'required|string|max:50',
            'game_password' => 'required|string|max:50',
            'note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Lấy thông tin package
        $package = ServicePackage::findOrFail($request->input('package_id'));

        // Kiểm tra số dư
        $user = User::findOrFail(auth()->id());
        if ($user->balance < $package->price) {
            return redirect()->back()
                ->with('error', 'Số dư tài khoản không đủ để thanh toán dịch vụ này.')
                ->withInput();
        }

        // Bắt đầu transaction
        DB::beginTransaction();
        try {
            // Tạo lịch sử dịch vụ
            $serviceHistory = ServiceHistory::create([
                'user_id' => auth()->id(),
                'game_service_id' => $request->input('service_id'),
                'service_package_id' => $package->id,
                'game_account' => $request->input('game_account'),
                'game_password' => $request->input('game_password'),
                'server' => $request->input('server'),
                'note' => $request->input('note'),
                'price' => $package->price,
                'status' => 'pending',
            ]);

            // Trừ tiền tài khoản
            $user->balance -= $package->price;
            $user->save();

            // Add balance transaction history
            MoneyTransaction::create([
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => -$package->price,
                'balance_before' => $user->balance + $package->price,
                'balance_after' => $user->balance,
                'description' => 'Thuê ' . GameService::find($request->input('service_id'))->name . ' #' . $serviceHistory->id,
                'reference_id' => $serviceHistory->id
            ]);
            DB::commit();

            return back()->with('success', 'Đặt dịch vụ thành công. Chúng tôi sẽ xử lý trong thời gian sớm nhất.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }
}
