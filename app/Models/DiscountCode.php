<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'max_discount_value',
        'min_purchase_amount',
        'is_active',
        'usage_limit',
        'usage_count',
        'per_user_limit',
        'applicable_to',
        'item_ids',
        'expire_date',
        'description'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expire_date' => 'datetime',
        'item_ids' => 'json',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'per_user_limit' => 'integer',
        'discount_value' => 'float',
        'max_discount_value' => 'float',
        'min_purchase_amount' => 'float',
        'is_active' => 'string',
    ];

    /**
     * Get the discount code usages.
     */
    public function usages()
    {
        return $this->hasMany(DiscountCodeUsage::class);
    }

    /**
     * Check if the discount code is valid
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->is_active === '1' &&
            ($this->usage_limit === null || $this->usage_count < $this->usage_limit) &&
            ($this->expire_date === null || $this->expire_date > now());
    }
}
