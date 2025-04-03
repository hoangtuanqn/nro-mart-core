<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MoneyWithdrawalHistory;

class MoneyWithdrawalHistoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $withdrawals = [
            [
                'user_id' => 1, // Giả sử user_id = 1 tồn tại
                'amount' => 500000,
                'user_note' => 'Rút tiền về tài khoản Vietcombank',
                'admin_note' => 'Đã chuyển khoản thành công',
                'status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Giả sử user_id = 2 tồn tại
                'amount' => 1000000,
                'user_note' => 'Rút tiền về Momo',
                'admin_note' => null,
                'status' => 'processing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, // Giả sử user_id = 3 tồn tại
                'amount' => 300000,
                'user_note' => 'Rút tiền về Techcombank',
                'admin_note' => 'Lỗi hệ thống ngân hàng',
                'status' => 'error',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($withdrawals as $withdrawal) {
            MoneyWithdrawalHistory::create($withdrawal);
        }
    }
}