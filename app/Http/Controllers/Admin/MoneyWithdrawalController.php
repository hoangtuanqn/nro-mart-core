<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MoneyTransaction;
use App\Models\MoneyWithdrawalHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoneyWithdrawalController extends Controller
{
    /**
     * Display a listing of the withdrawal requests.
     */
    public function index()
    {
        $withdrawals = MoneyWithdrawalHistory::with('user')
            ->latest() // Using the latest() method for better readability
            ->get();

        return view('admin.history.money-withdrawal-history', compact('withdrawals'));
    }

    /**
     * Mark a withdrawal request as success.
     */
    public function approve(MoneyWithdrawalHistory $withdrawal, Request $request)
    {
        if ($withdrawal->status !== 'processing') {
            return back()->with('error', 'Yêu cầu rút tiền này không thể duyệt.');
        }

        try {
            DB::beginTransaction();

            $withdrawal->update([
                'status' => 'success',
                'admin_note' => $request->admin_note,
            ]);

            DB::commit();

            return back()->with('success', 'Yêu cầu rút tiền đã được duyệt thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }

    /**
     * Mark a withdrawal request as error.
     */
    public function reject(MoneyWithdrawalHistory $withdrawal, Request $request)
    {
        if ($withdrawal->status !== 'processing') {
            return back()->with('error', 'Yêu cầu rút tiền này không thể từ chối.');
        }

        try {
            DB::beginTransaction();

            $withdrawal->update([
                'status' => 'error',
                'admin_note' => $request->admin_note,
            ]);

            // Hoàn tiền cho người dùng
            $user = User::find($withdrawal->user_id);
            $user->update(['balance' => $user->getAttribute('balance') + $withdrawal->amount]);

            // Lưu lịch sử hoàn tiền người dùng
            $moneyTransaction = new MoneyTransaction();
            $moneyTransaction->user_id = $withdrawal->user_id;
            $moneyTransaction->type = 'refund';
            $moneyTransaction->amount = $withdrawal->amount;
            $moneyTransaction->balance_before = $user->getAttribute('balance');
            $moneyTransaction->balance_after = $user->getAttribute('balance') + $withdrawal->amount;
            $moneyTransaction->description = $request->input('admin_note') ?? 'Hoàn tiền cho yêu cầu rút tiền bị từ chối ID: ' . $withdrawal->id;
            $moneyTransaction->save();

            DB::commit();

            return back()->with('success', 'Yêu cầu rút tiền đã bị từ chối và tiền đã được hoàn lại cho người dùng.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }
}