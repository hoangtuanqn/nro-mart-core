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

class DiscountCodeUsage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discount_code_id',
        'user_id',
        'context',
        'item_id',
        'original_price',
        'discounted_price',
        'discount_amount',
        'used_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'original_price' => 'float',
        'discounted_price' => 'float',
        'discount_amount' => 'float',
        'used_at' => 'datetime'
    ];

    /**
     * Get the discount code that was used.
     */
    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class);
    }

    /**
     * Get the user who used the discount code.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
