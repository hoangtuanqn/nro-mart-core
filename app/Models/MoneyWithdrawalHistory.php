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

class MoneyWithdrawalHistory extends Model
{
    use HasFactory;
    // Tên bảng tương ứng trong cơ sở dữ liệu
    protected $table = 'money_withdrawal_histories';

    // Các cột có thể được gán hàng loạt (mass assignable)
    protected $fillable = [
        'user_id',
        'amount',
        'user_note',
        'admin_note',
        'status',
    ];

    // Ép kiểu dữ liệu cho các cột
    protected $casts = [
        'status' => 'string', // Ép kiểu status thành chuỗi (enum)
        'amount' => 'integer', // Ép kiểu amount thành số nguyên
    ];

    // Mối quan hệ belongsTo với bảng users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
