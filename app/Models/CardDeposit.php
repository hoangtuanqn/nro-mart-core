<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'telco',
        'amount',
        'received_amount',
        'serial',
        'pin',
        'request_id',
        'status',
    ];

    /**
     * Get the user that owns the card deposit.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}