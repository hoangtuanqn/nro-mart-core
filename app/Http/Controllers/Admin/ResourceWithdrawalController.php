<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResourceWithdrawalController extends Controller
{
    /**
     * Display a listing of the resource withdrawal requests.
     */
    public function index()
    {
        $withdrawals = WithdrawalHistory::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.history.resource-withdrawal-history', compact('withdrawals'));
    }

    /**
     * Mark a withdrawal request as completed.
     */
    public function approve(WithdrawalHistory $withdrawal, Request $request)
    {
        if ($withdrawal->status !== 'processing') {
            return back()->with('error', 'Yêu cầu rút này không thể duyệt.');
        }

        try {
            DB::beginTransaction();

            $withdrawal->update([
                'status' => 'success',
                'admin_note' => $request->admin_note,
            ]);

            DB::commit();

            return back()->with('success', 'Yêu cầu rút tài nguyên đã được duyệt thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }

    /**
     * Mark a withdrawal request as cancelled.
     */
    public function reject(WithdrawalHistory $withdrawal, Request $request)
    {
        if ($withdrawal->status !== 'processing') {
            return back()->with('error', 'Yêu cầu rút này không thể từ chối.');
        }

        try {
            DB::beginTransaction();

            // Get user
            $user = User::findOrFail($withdrawal->user_id);

            // Restore resources based on type
            if ($withdrawal->type === 'gold') {
                $user->gold += $withdrawal->amount;
            } else { // gem
                $user->gem += $withdrawal->amount;
            }

            $user->save();

            // Update withdrawal status
            $withdrawal->update([
                'status' => 'error',
                'admin_note' => $request->admin_note,
            ]);

            DB::commit();

            return back()->with('success', 'Yêu cầu rút tài nguyên đã bị từ chối và đã hoàn trả lại cho người dùng.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }
}