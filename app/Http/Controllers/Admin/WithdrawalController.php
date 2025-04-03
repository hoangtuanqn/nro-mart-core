<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MoneyWithdrawalHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the withdrawal requests.
     */
    public function index()
    {
        $withdrawals = MoneyWithdrawalHistory::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.history.withdrawal-history', compact('withdrawals'));
    }

    /**
     * Mark a withdrawal request as success.
     */
    public function success(MoneyWithdrawalHistory $withdrawal, Request $request)
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
    public function error(MoneyWithdrawalHistory $withdrawal, Request $request)
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

            DB::commit();

            return back()->with('success', 'Yêu cầu rút tiền đã bị từ chối và tiền đã được hoàn lại cho người dùng.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }
}