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
        'transaction_id',
        'user_id',
        'amount',
        'content',
        'bank'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
