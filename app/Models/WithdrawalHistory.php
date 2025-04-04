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
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WithdrawalHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'character_name',
        'server',
        'user_note',
        'admin_note',
        'status'
    ];

    protected $casts = [
        'amount' => 'integer',
        'server' => 'integer'
    ];

    /**
     * Get the user that owns the withdrawal history.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
