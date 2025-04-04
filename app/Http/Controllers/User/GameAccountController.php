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

use App\Models\GameAccount;
use App\Models\MoneyTransaction;
use App\Models\DiscountCode;
use App\Http\Controllers\DiscountCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameAccountController extends Controller
{
    public function show($id)
    {
        $account = GameAccount::findOrFail($id);

        // Convert JSON string to array or provide empty array if null
        $images = json_decode($account->images) ?? [];

        return view("user.account.detail", compact('account', 'images'));
    }


    public function purchase(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $account = GameAccount::where('id', $id)
                ->where('status', 'available')
                ->lockForUpdate()
                ->firstOrFail();

            $user = Auth::user();
            $finalPrice = $account->price;
            $discountAmount = 0;
            $discountCodeController = new DiscountCodeController();

            // Check for discount code if provided
            if ($request->filled('discount_code')) {
                $discountCode = DiscountCode::where('code', $request->discount_code)
                    ->where('is_active', '1')
                    ->first();

                if ($discountCode) {
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

                    // Apply discount code
                    if ($discountCode) {
                        // Update usage count directly in database
                        DB::table('discount_codes')
                            ->where('id', $discountCode->id)
                            ->increment('usage_count');

                        // Record usage details
                        DB::table('discount_code_usages')->insert([
                            'discount_code_id' => $discountCode->id,
                            'user_id' => $user->id,
                            'context' => 'account',
                            'item_id' => $account->id,
                            'original_price' => $account->price,
                            'discounted_price' => $finalPrice,
                            'discount_amount' => $discountAmount,
                            'used_at' => now(),
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
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
            $balanceAfter = $balanceBefore - $finalPrice;

            // Use direct DB update instead of model save
            DB::table('users')
                ->where('id', $user->id)
                ->update(['balance' => $balanceAfter]);

            // Update account status
            DB::table('game_accounts')
                ->where('id', $account->id)
                ->update([
                    'status' => 'sold',
                    'buyer_id' => $user->id
                ]);

            // Thêm lịch sử biến động số dư
            DB::table('money_transactions')->insert([
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => -$finalPrice,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => 'Mua tài khoản #' . $account->id . ($discountAmount > 0 ? ' (Giảm giá: ' . number_format($discountAmount) . 'đ)' : ''),
                'reference_id' => $account->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mua tài khoản thành công!',
                'data' => [
                    'new_balance' => $balanceAfter
                ],
                'redirect_url' => route('profile.purchased-accounts')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi mua tài khoản: ' . $e->getMessage()
            ]);
        }
    }
}
