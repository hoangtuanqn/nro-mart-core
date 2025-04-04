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

class BankDeposit extends Model
{
    use HasFactory;

    protected $primaryKey = 'transaction_id'; // Đặt khóa chính là transaction_id
    public $incrementing = false; // Không tự động tăng
    protected $fillable = [
        'transaction_id',
        'user_id',
        'account_number',
        'amount',
        'content',
        'bank'
    ];

    protected $casts = [
        'amount' => 'decimal:0',
        'bank' => 'string', // Added cast for 'bank'
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
