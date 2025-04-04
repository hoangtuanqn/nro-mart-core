<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiscountCodeController extends Controller
{
    /**
     * Validate a discount code for a specific context.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'context' => 'required|string|in:account,random_account,service',
            'item_id' => 'required|integer'
        ]);

        $code = $request->input('code');
        $context = $request->input('context');
        $itemId = $request->input('item_id');

        // Find the discount code
        $discountCode = DiscountCode::where('code', $code)
            ->where('is_active', '1')
            ->first();

        if (!$discountCode) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn'
            ]);
        }

        // Check if the code is expired
        if ($discountCode->expire_date && now() > $discountCode->expire_date) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá đã hết hạn'
            ]);
        }

        // Check if the code has reached its usage limit
        if ($discountCode->usage_limit && $discountCode->usage_count >= $discountCode->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá đã đạt giới hạn sử dụng'
            ]);
        }

        // Check context-specific rules
        if ($discountCode->applicable_to && $discountCode->applicable_to !== $context) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không áp dụng cho loại giao dịch này'
            ]);
        }

        // Check if the user already used this code, if per user limit is set
        if (Auth::check() && $discountCode->per_user_limit) {
            $userUsageCount = $discountCode->usages()
                ->where('user_id', Auth::id())
                ->count();

            if ($userUsageCount >= $discountCode->per_user_limit) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã sử dụng mã giảm giá này đủ số lần cho phép'
                ]);
            }
        }

        // For item-specific discount codes, check if the code applies to this item
        if ($discountCode->item_ids) {
            $itemIds = json_decode($discountCode->item_ids, true);
            if (!in_array($itemId, $itemIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá không áp dụng cho mục này'
                ]);
            }
        }

        // Get the original price based on context and item_id
        $originalPrice = $this->getOriginalPrice($context, $itemId);

        if ($originalPrice === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin giá của mục này'
            ]);
        }

        // Check minimum purchase amount
        if ($discountCode->min_purchase_amount > 0 && $originalPrice < $discountCode->min_purchase_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Giá trị đơn hàng không đủ để áp dụng mã giảm giá này'
            ]);
        }

        // Calculate discount
        $discountedPrice = $this->calculateDiscountedPrice($originalPrice, $discountCode);

        return response()->json([
            'success' => true,
            'message' => 'Mã giảm giá hợp lệ',
            'data' => [
                'discount_code' => $discountCode->code,
                'discount_type' => $discountCode->discount_type,
                'discount_value' => $discountCode->discount_value,
                'original_price' => $originalPrice,
                'discounted_price' => $discountedPrice,
                'savings' => $originalPrice - $discountedPrice
            ]
        ]);
    }

    /**
     * Get original price based on context and item_id
     *
     * @param string $context
     * @param int $itemId
     * @return float
     */
    private function getOriginalPrice($context, $itemId)
    {
        switch ($context) {
            case 'account':
                // Get price from accounts table
                $account = DB::table('game_accounts')->where('id', $itemId)->first();
                return $account ? $account->price : 0;

            case 'random_account':
                // Get price from random_category_accounts table
                $randomAccount = DB::table('random_category_accounts')->where('id', $itemId)->first();
                return $randomAccount ? $randomAccount->price : 0;

            case 'service':
                // Get price from service_packages table
                $servicePackage = DB::table('service_packages')->where('id', $itemId)->first();
                return $servicePackage ? $servicePackage->price : 0;

            default:
                return 0;
        }
    }

    /**
     * Calculate discounted price based on original price and discount code
     *
     * @param float $originalPrice
     * @param DiscountCode $discountCode
     * @return float
     */
    private function calculateDiscountedPrice($originalPrice, $discountCode)
    {
        if ($discountCode->discount_type === 'percentage') {
            $discount = $originalPrice * ($discountCode->discount_value / 100);
            // If there's a maximum discount value, apply it
            if ($discountCode->max_discount_value && $discount > $discountCode->max_discount_value) {
                $discount = $discountCode->max_discount_value;
            }
            return $originalPrice - $discount;
        } else { // fixed_amount
            return max(0, $originalPrice - $discountCode->discount_value);
        }
    }

    /**
     * Apply a discount code during a purchase
     *
     * @param DiscountCode $discountCode
     * @param string $context
     * @param int $itemId
     * @param int $userId
     * @param float $originalPrice
     * @param float $discountedPrice
     * @return void
     */
    public function applyDiscountCode($discountCode, $context, $itemId, $userId, $originalPrice, $discountedPrice)
    {
        try {
            // Increment usage count
            DB::table('discount_codes')
                ->where('id', $discountCode->id)
                ->increment('usage_count');

            // Record usage
            DB::table('discount_code_usages')->insert([
                'discount_code_id' => $discountCode->id,
                'user_id' => $userId,
                'context' => $context,
                'item_id' => $itemId,
                'original_price' => $originalPrice,
                'discounted_price' => $discountedPrice,
                'discount_amount' => $originalPrice - $discountedPrice,
                'used_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } catch (\Exception $e) {
            // Log error but don't fail transaction
            Log::error('Error applying discount code: ' . $e->getMessage());
        }
    }
}
