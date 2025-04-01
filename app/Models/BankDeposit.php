<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDeposit extends Model
{
    use HasFactory;

    protected $primaryKey = 'transaction_id'; // Đặt khóa chính là transaction_id
    public $incrementing = false; // Không tự động tăng
    protected $fillable = [
        'user_id',
        'bank_account_id',
        'transaction_id',
        'amount',
        'transaction_content',
        'proof_image',
        'status',
        'admin_note',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'amount' => 'decimal:0',
    ];

    /**
     * Get the user who made the deposit.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bank account used for the deposit.
     */
    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }

    /**
     * Get the transaction associated with this deposit.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
