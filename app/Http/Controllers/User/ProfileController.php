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
use App\Models\GameAccount;
use App\Models\MoneyTransaction;
use App\Models\RandomCategoryAccount;
use App\Models\ServiceHistory;  // Fix the import here
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
        $transactions = MoneyTransaction::where('user_id', Auth::id())
            ->where('type', 'card')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.deposit-card', [
            'user' => $request->user(),
            'transactions' => $transactions,
            'title' => $title
        ]);
    }

    public function depositAtm(Request $request)
    {
        $title = 'Nạp tiền ATM';
        $transactions = MoneyTransaction::where('user_id', Auth::id())
            ->where('type', 'atm')
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
}
