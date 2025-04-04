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

class BankAccount extends Model
{
    use HasFactory;
    protected $table = 'bank_accounts';
    protected $fillable = [
        'bank_name',        // Tên ngân hàng
        'account_name',     // Tên chủ tài khoản
        'account_number',   // Số tài khoản
        'branch',           // Chi nhánh
        'note',             // Ghi chú
        'is_active',        // Trạng thái hiển thị
        'auto_confirm',      // Trạng thái tự động xác nhận chuyển tiền
        'prefix',            // Cú pháp nạp tiền,
        'access_token'      // Access Token bên SePay.VN
    ];
}
