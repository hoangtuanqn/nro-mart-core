<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    protected $table = 'bank_accounts';
    protected $fillable = [
        'bank_name',        // Tên ngân hàng
        'account_number',   // Số tài khoản
        'branch',           // Chi nhánh
        'note',             // Ghi chú
        'is_active',        // Trạng thái hiển thị
        'auto_confirm'      // Trạng thái tự động xác nhận chuyển tiền
    ];
}
