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

class RandomAccountPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'original_price',
        'final_price',
        'discount_code',
        'discount_amount',
        'transaction_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'original_price' => 'decimal:0',
        'final_price' => 'decimal:0',
        'discount_amount' => 'decimal:0',
    ];

    /**
     * Get the user who purchased the random account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the random account that was purchased.
     */
    public function account()
    {
        return $this->belongsTo(RandomCategoryAccount::class, 'account_id');
    }

    /**
     * Get the transaction associated with this purchase.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
