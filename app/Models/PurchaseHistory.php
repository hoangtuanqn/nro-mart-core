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

class PurchaseHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'game_account_id',
        'amount',
        'account_details',
    ];

    /**
     * Get the user that purchased the account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the game account that was purchased.
     */
    public function gameAccount()
    {
        return $this->belongsTo(GameAccount::class);
    }
}