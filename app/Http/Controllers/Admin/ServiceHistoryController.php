<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceHistory;
use App\Models\User;
use App\Models\MoneyTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceHistoryController extends Controller
{
    /**
     * Approve a service request
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Request $request, $id)
    {
        if (app()->environment('demo')) {
            return redirect()->back()
                ->with('error', 'Đang ở môi trường demo. Bạn không thể thay đổi dữ liệu.');
        }

        try {
            DB::beginTransaction();

            $service = ServiceHistory::findOrFail($id);

            // Check if service is already completed or cancelled
            if ($service->status === 'completed' || $service->status === 'cancelled') {
                return redirect()->back()
                    ->with('error', 'Dịch vụ này đã được xử lý trước đó.');
            }

            // Update service status
            $service->status = 'completed';
            $service->admin_note = $request->admin_note;
            $service->completed_at = now();
            $service->save();

            DB::commit();

            return redirect()->back()
                ->with('success', 'Dịch vụ đã được hoàn thành thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error approving service: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Reject a service request
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Request $request, $id)
    {
        if (app()->environment('demo')) {
            return redirect()->back()
                ->with('error', 'Đang ở môi trường demo. Bạn không thể thay đổi dữ liệu.');
        }

        $request->validate([
            'admin_note' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $service = ServiceHistory::findOrFail($id);

            // Check if service is already completed or cancelled
            if ($service->status === 'completed' || $service->status === 'cancelled') {
                return redirect()->back()
                    ->with('error', 'Dịch vụ này đã được xử lý trước đó.');
            }

            $user = User::findOrFail($service->user_id);
            $refundAmount = $service->price;

            // Update service status
            $service->status = 'cancelled';
            $service->admin_note = $request->admin_note;
            $service->save();

            // Refund user's balance
            $balanceBefore = $user->balance;
            $balanceAfter = $balanceBefore + $refundAmount;
            
            $user->balance = $balanceAfter;
            $user->save();

            // Create refund transaction record
            MoneyTransaction::create([
                'user_id' => $user->id,
                'type' => 'refund',
                'amount' => $refundAmount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => 'Hoàn tiền dịch vụ #' . $service->id . ' (' . ($service->gameService->name ?? 'Dịch vụ') . ')',
                'reference_id' => $service->id
            ]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Dịch vụ đã được hủy và hoàn tiền cho người dùng thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error rejecting service: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 