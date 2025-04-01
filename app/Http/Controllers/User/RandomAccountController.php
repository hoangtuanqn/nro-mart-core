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
use App\Http\Controllers\DiscountCodeController;
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
        // : SQLSTATE[42S02]: Base table or view not found: 1146 Table 'gameshop.accounts' doesn't exist (Connection: mysql, SQL: update `accounts` set `status` = sold, `buyer_id` = 1 where `id` = 5)
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
                    ->where('status', 'active')
                    ->first();

                if (!$discountCode) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn'
                    ]);
                }

                // Check if the code is expired
                if ($discountCode->expire_date && now() > $discountCode->expire_date) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Mã giảm giá đã hết hạn'
                    ]);
                }
               

                // Check if the code has reached its usage limit
                if ($discountCode->usage_limit && $discountCode->usage_count >= $discountCode->usage_limit) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Mã giảm giá đã đạt giới hạn sử dụng'
                    ]);
                }

                // Check if applicable to this context
                if ($discountCode->applicable_to && $discountCode->applicable_to !== 'random_account') {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Mã giảm giá không áp dụng cho loại giao dịch này'
                    ]);
                }

                // Check if the user already used this code, if per user limit is set
                if ($discountCode->per_user_limit) {
                    $userUsageCount = $discountCode->usages()
                        ->where('user_id', $user->id)
                        ->count();

                    if ($userUsageCount >= $discountCode->per_user_limit) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn đã sử dụng mã giảm giá này đủ số lần cho phép'
                        ]);
                    }
                }

                // For item-specific discount codes, check if the code applies to this item
                if ($discountCode->item_ids) {
                    $itemIds = json_decode($discountCode->item_ids, true);
                    if (!in_array($account->id, $itemIds)) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Mã giảm giá không áp dụng cho tài khoản random này'
                        ]);
                    }
                }

                // Calculate discount
                if ($discountCode->discount_type === 'percentage') {
                    $discountAmount = ($account->price * $discountCode->discount_value) / 100;
                    // Apply max discount if set
                    if ($discountCode->max_discount_value && $discountAmount > $discountCode->max_discount_value) {
                        $discountAmount = $discountCode->max_discount_value;
                    }
                } else {
                    $discountAmount = $discountCode->discount_value;
                }


                // Calculate final price
                $finalPrice = $account->price - $discountAmount;
                if ($finalPrice < 0) {
                    $finalPrice = 0;
                }

                // Update usage count directly in database
                DB::table('discount_codes')
                    ->where('id', $discountCode->id)
                    ->increment('usage_count');

                // Record usage details
                DB::table('discount_code_usages')->insert([
                    'discount_code_id' => $discountCode->id,
                    'user_id' => $user->id,
                    'context' => 'random_account',
                    'item_id' => $account->id,
                    'original_price' => $account->price,
                    'discounted_price' => $finalPrice,
                    'discount_amount' => $discountAmount,
                    'used_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
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
            $balanceAfter = $balanceBefore - $finalPrice;

            // Use direct DB update instead of model save
            DB::table('users')
                ->where('id', $user->id)
                ->update(['balance' => $balanceAfter]);

            // Update account status
            DB::table('random_category_accounts')
                ->where('id', $account->id)
                ->update([
                    'status' => 'sold',
                    'buyer_id' => $user->id
                ]);

            // Add transaction history
            DB::table('money_transactions')->insert([
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => -$finalPrice,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => 'Mua tài khoản random #' . $account->id . ($discountAmount > 0 ? ' (Giảm giá: ' . number_format($discountAmount) . 'đ)' : ''),
                'reference_id' => 'RA-' . $account->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mua tài khoản random thành công!',
                'data' => [
                    'new_balance' => $balanceAfter
                ],
                'redirect_url' => route('profile.purchased-random-accounts')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Apply a discount code and record its usage
     *
     * @param DiscountCode $discountCode
     * @param int $userId
     * @param string $context
     * @param int $itemId
     * @param float $originalPrice
     * @param float $discountedPrice
     * @param float $discountAmount
     * @return void
     */
    private function applyDiscountCode(
        DiscountCode $discountCode,
        int $userId,
        string $context,
        int $itemId,
        float $originalPrice,
        float $discountedPrice,
        float $discountAmount
    ) {
        // Update usage count directly in database
        DB::table('discount_codes')
            ->where('id', $discountCode->id)
            ->increment('usage_count');

        // Record usage details
        DB::table('discount_code_usages')->insert([
            'discount_code_id' => $discountCode->id,
            'user_id' => $userId,
            'context' => $context,
            'item_id' => $itemId,
            'original_price' => $originalPrice,
            'discounted_price' => $discountedPrice,
            'discount_amount' => $discountAmount,
            'used_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
