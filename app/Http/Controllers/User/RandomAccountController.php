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

use App\Models\RandomCategoryAccount;
use App\Models\DiscountCode;
use App\Models\MoneyTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RandomAccountController extends Controller
{
    public function show($id)
    {
        $account = RandomCategoryAccount::findOrFail($id);

        return view("user.random.detail", compact('account'));
    }

    public function purchase(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $account = RandomCategoryAccount::where('id', $id)
                ->where('status', 'available')
                ->lockForUpdate()
                ->firstOrFail();

            $user = Auth::user();
            $discountAmount = 0;
            $finalPrice = $account->price;

            // Check discount code if provided
            if ($request->filled('discount_code')) {
                $discountCode = DiscountCode::where('code', $request->discount_code)
                    ->where('is_active', true)
                    ->where('usage_limit', '>', 0)
                    ->where(function ($query) {
                        $query->whereNull('expires_at')
                            ->orWhere('expires_at', '>', now());
                    })
                    ->first();

                if ($discountCode) {
                    // Calculate discount
                    if ($discountCode->type === 'percentage') {
                        $discountAmount = ($account->price * $discountCode->value) / 100;
                    } else {
                        $discountAmount = $discountCode->value;
                    }

                    // Apply maximum discount if needed
                    if ($discountCode->max_discount > 0 && $discountAmount > $discountCode->max_discount) {
                        $discountAmount = $discountCode->max_discount;
                    }

                    // Calculate final price
                    $finalPrice = $account->price - $discountAmount;
                    if ($finalPrice < 0)
                        $finalPrice = 0;

                    // Update discount code usage
                    $discountCode->usage_limit--;
                    $discountCode->save();
                }
            }

            if ($user->balance < $finalPrice) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Số dư không đủ để mua tài khoản này'
                ]);
            }

            // Update user balance
            $balanceBefore = $user->balance;
            $user->balance -= $finalPrice;
            $user->save();

            // Update account status
            $account->status = 'sold';
            $account->buyer_id = $user->id;
            $account->save();

            // Add transaction history
            $transaction = new MoneyTransaction();
            $transaction->user_id = $user->id;
            $transaction->type = 'purchase';
            $transaction->amount = -$finalPrice;
            $transaction->balance_before = $balanceBefore;
            $transaction->balance_after = $user->balance;
            $transaction->description = 'Mua tài khoản random #' . $account->id;
            $transaction->reference_id = 'RA-' . $account->id;
            $transaction->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mua tài khoản thành công',
                'data' => [
                    'new_balance' => $user->balance,
                    'account' => $account,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
}
