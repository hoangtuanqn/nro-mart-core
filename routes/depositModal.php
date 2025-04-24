<?php

use App\Models\BankAccount;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Deposit Modal API Routes
|--------------------------------------------------------------------------
|
| Routes dành riêng cho modal nạp tiền, được đặt trong middleware web
| để có thể truy cập session xác thực người dùng.
|
*/

// Bank accounts API for deposit modal
Route::middleware('web')->prefix('api/deposit-modal')->group(function () {
    
    // Get bank accounts
    Route::get('/bank-accounts', function () {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Yêu cầu đăng nhập để nạp tiền'
            ]);
        }

        try {
            $bankAccounts = BankAccount::where('is_active', 1)
                ->orderBy('id', 'asc')
                ->get();

            if ($bankAccounts->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có tài khoản ngân hàng nào được cấu hình'
                ]);
            }

            $formattedAccounts = $bankAccounts->map(function ($account) {
                $prefix = $account->prefix ?: 'NAP';
                
                return [
                    'id' => $account->id,
                    'bank_name' => $account->bank_name,
                    'account_name' => $account->account_name,
                    'account_number' => $account->account_number,
                    'branch' => $account->branch,
                    'note' => $account->note,
                    'prefix' => $prefix,
                    'auto_confirm' => $account->auto_confirm,
                    'user_id' => auth()->id(),
                    'content' => $prefix . auth()->id()
                ];
            });

            return response()->json([
                'success' => true,
                'bankAccounts' => $formattedAccounts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tải dữ liệu: ' . $e->getMessage()
            ], 500);
        }
    });
}); 