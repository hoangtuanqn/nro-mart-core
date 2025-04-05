<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BankAccount::insert([
            [
                'bank_name' => 'MBBank',
                'account_name' => 'Phạm Hoàng Tuấn',
                'account_number' => '259876543210',
                'branch' => 'Mộ Đức, Quảng Ngãi',
                'note' => 'Nạp tự động, cộng tiền trong 1p',
                'is_active' => true,
                'auto_confirm' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
