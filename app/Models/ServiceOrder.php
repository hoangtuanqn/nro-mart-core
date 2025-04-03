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

class ServiceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'account_info',
        'note',
        'original_price',
        'final_price',
        'discount_code',
        'discount_amount',
        'transaction_id',
        'status',
        'result',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'original_price' => 'decimal:0',
        'final_price' => 'decimal:0',
        'discount_amount' => 'decimal:0',
    ];

    /**
     * Get the user who ordered the service.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the service package.
     */
    public function package()
    {
        return $this->belongsTo(ServicePackage::class, 'package_id');
    }

    /**
     * Get the transaction associated with this order.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
