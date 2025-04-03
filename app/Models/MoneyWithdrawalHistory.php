<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MoneyWithdrawalHistory extends Model
{
    use HasFactory;

    protected $table = 'money_withdrawal_histories';

    protected $fillable = [
        'user_id',
        'amount',
        'user_note',
        'admin_note',
        'status'
    ];

    protected $casts = [
        'amount' => 'integer',
    ];

    /**
     * Get the user that owns the withdrawal history.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}