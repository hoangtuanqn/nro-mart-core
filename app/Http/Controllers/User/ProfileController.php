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

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\BankAccount;
use App\Models\BankDeposit;
use App\Models\CardDeposit;
use App\Models\GameAccount;
use App\Models\MoneyTransaction;
use App\Models\RandomCategoryAccount;
use App\Models\ServiceHistory;  // Fix the import here
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\LuckyWheelHistory;
use App\Models\WithdrawalHistory;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index(Request $request): View
    {
        return view('user.profile.profile', [
            'user' => $request->user(),
            'title' => 'Thông tin tài khoản'
        ]);
    }

    public function viewChangePassword(Request $request)
    {
        $title = 'Đổi mật khẩu';
        return view('user.profile.change-password', [
            'user' => $request->user(),
            'title' => $title
        ]);
    }

    /**
     * Handle the password change form submission.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (!Hash::check($value, $request->user()->password)) {
                        $fail('Mật khẩu hiện tại không chính xác.');
                    }
                }
            ],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.change-password')->with('success', 'Mật khẩu đã được cập nhật thành công.');
    }

    public function transactionHistory(Request $request)
    {
        $title = 'Lịch sử giao dịch';
        $transactions = MoneyTransaction::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('user.profile.transaction-history', [
            'user' => $request->user(),
            'transactions' => $transactions,
            'title' => $title
        ]);
    }

    public function purchasedAccounts(Request $request)
    {
        $title = 'Tài khoản đã mua';
        $transactions = GameAccount::where('buyer_id', Auth::id())->where('status', 'sold')->paginate(perPage: 10);
        return view('user.profile.purchased-accounts', [
            'user' => $request->user(),
            'transactions' => $transactions,
            'title' => $title
        ]);
    }

    public function servicesHistory(Request $request)
    {
        $title = 'Dịch vụ đã thuê';
        $serviceHistories = ServiceHistory::with(['gameService', 'servicePackage'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.services-history', [
            'user' => $request->user(),
            'serviceHistories' => $serviceHistories,
            'title' => $title
        ]);
    }

    public function getServiceDetail($id)
    {
        try {
            $service = ServiceHistory::with(['gameService', 'servicePackage'])
                ->where('user_id', Auth::id())
                ->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'id' => $service->id,
                'created_at' => $service->created_at,
                'game_service' => [
                    'name' => $service->gameService->name
                ],
                'game_account' => $service->game_account,
                'server' => $service->server,
                'service_package' => [
                    'name' => $service->servicePackage->name
                ],
                'price' => $service->price,
                'status_html' => display_status_service($service->status),
                'admin_note' => $service->admin_note ?? 'Không có ghi chú'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể tải thông tin dịch vụ'
            ], 500);
        }
    }

    public function purchasedRandomAccounts(Request $request)
    {
        $title = 'Tài khoản random đã mua';
        $transactions = RandomCategoryAccount::where('buyer_id', Auth::id())->where('status', 'sold')->paginate(perPage: 10);
        return view('user.profile.purchased-random-accounts', [
            'user' => $request->user(),
            'transactions' => $transactions,
            'title' => $title
        ]);
    }

    public function depositCard(Request $request)
    {
        $title = 'Nạp tiền thẻ cào';
        $transactions = CardDeposit::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.deposit-card', [
            'transactions' => $transactions,
            'title' => $title
        ]);
    }

    public function depositAtm(Request $request)
    {
        $title = 'Nạp tiền ATM';
        $transactions = BankDeposit::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get bank accounts from the database
        $bankAccounts = BankAccount::where('is_active', true)
            ->orderBy('id', 'asc')
            ->get();

        // Ensure each bank account has a prefix
        foreach ($bankAccounts as $account) {
            if (empty($account->prefix)) {
                $account->prefix = 'NAP' . $request->user()->id;
            }
        }

        return view('user.profile.deposit-atm', [
            'user' => $request->user(),
            'transactions' => $transactions,
            'bankAccounts' => $bankAccounts,
            'title' => $title
        ]);
    }

    /**
     * Display the user's lucky wheel history.
     */
    public function luckyWheelHistory(Request $request)
    {
        $title = 'Lịch sử vận may';
        $wheelHistories = LuckyWheelHistory::with('luckyWheel')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.wheels-history', [
            'user' => $request->user(),
            'wheelHistories' => $wheelHistories,
            'title' => $title
        ]);
    }

    /**
     * Get lucky wheel history detail.
     */
    public function getLuckyWheelDetail($id)
    {
        try {
            $history = LuckyWheelHistory::with('luckyWheel')
                ->where('user_id', Auth::id())
                ->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'id' => $history->id,
                'created_at' => $history->created_at,
                'lucky_wheel' => [
                    'name' => $history->luckyWheel->name
                ],
                'spin_count' => $history->spin_count,
                'total_cost' => $history->total_cost,
                'reward_type' => $history->reward_type,
                'reward_amount' => $history->reward_amount,
                'description' => $history->description
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể tải thông tin vòng quay may mắn'
            ], 500);
        }
    }

    /**
     * Show the gold withdrawal page.
     */
    public function withdrawGold()
    {
        $title = "Rút vàng";
        $user = auth()->user();
        $withdrawals = WithdrawalHistory::where('user_id', $user->id)
            ->where('type', 'gold')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.withdraw-gold', compact('title', 'withdrawals'));
    }

    /**
     * Process a gold withdrawal request.
     */
    public function processWithdrawGold(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1000|max:1000000000',
            'character_name' => 'required|string|max:50',
            'server' => 'required|integer|min:1|max:13',
            'user_note' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        if ($user->gold < $request->amount) {
            return back()->with('error', 'Số vàng không đủ để thực hiện giao dịch.')->withInput();
        }

        try {
            DB::beginTransaction();

            // Tạo yêu cầu rút vàng
            WithdrawalHistory::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'gold',
                'character_name' => $request->character_name,
                'server' => $request->server,
                'user_note' => $request->user_note,
                'status' => 'processing',
            ]);

            // Trừ vàng từ tài khoản người dùng
            $user->gold -= $request->amount;
            $user->save();

            DB::commit();

            return back()->with('success', 'Yêu cầu rút vàng đã được gửi thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }

    /**
     * Show the gem withdrawal page.
     */
    public function withdrawGem()
    {
        $title = "Rút ngọc";
        $user = auth()->user();
        $withdrawals = WithdrawalHistory::where('user_id', $user->id)
            ->where('type', 'gem')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.withdraw-gem', compact('title', 'withdrawals'));
    }

    /**
     * Process a gem withdrawal request.
     */
    public function processWithdrawGem(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:10|max:10000',
            'character_name' => 'required|string|max:50',
            'server' => 'required|integer|min:1|max:13',
            'user_note' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        if ($user->gem < $request->amount) {
            return back()->with('error', 'Số ngọc không đủ để thực hiện giao dịch.')->withInput();
        }

        try {
            DB::beginTransaction();

            // Tạo yêu cầu rút ngọc
            WithdrawalHistory::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'gem',
                'character_name' => $request->character_name,
                'server' => $request->server,
                'user_note' => $request->user_note,
                'status' => 'processing',
            ]);

            // Trừ ngọc từ tài khoản người dùng
            $user->gem -= $request->amount;
            $user->save();

            DB::commit();

            return back()->with('success', 'Yêu cầu rút ngọc đã được gửi thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }

    /**
     * Get withdrawal detail for AJAX request
     */
    public function getWithdrawalDetail($id)
    {
        try {
            $withdrawal = WithdrawalHistory::findOrFail($id);

            // Check if withdrawal belongs to current user
            if ($withdrawal->user_id !== auth()->id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn không có quyền xem thông tin này'
                ], 403);
            }

            // Get status HTML

            return response()->json([
                'status' => 'success',
                'id' => $withdrawal->id,
                'user_id' => $withdrawal->user_id,
                'amount' => $withdrawal->amount,
                'type' => $withdrawal->type,
                'character_name' => $withdrawal->character_name,
                'server' => $withdrawal->server,
                'user_note' => $withdrawal->user_note,
                'admin_note' => $withdrawal->admin_note,
                'status_html' => display_status($withdrawal->status),
                'created_at' => $withdrawal->created_at,
                'updated_at' => $withdrawal->updated_at
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy thông tin yêu cầu rút'
            ], 404);
        }
    }
}
