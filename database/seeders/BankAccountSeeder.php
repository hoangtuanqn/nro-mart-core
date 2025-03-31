<?php

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
                'account_number' => '259876543210',
                'branch' => 'Mộ Đức, Quảng Ngãi',
                'note' => 'Nạp nhanh',
                'is_active' => true,
                'auto_confirm' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'bank_name' => 'Techcombank',
            //     'account_number' => '0987654321',
            //     'branch' => 'TP. Hồ Chí Minh',
            //     'note' => 'Tài khoản phụ',
            //     'is_active' => true,
            //     'auto_confirm' => true,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            // [
            //     'bank_name' => 'BIDV',
            //     'account_number' => '1122334455',
            //     'branch' => 'Đà Nẵng',
            //     'note' => 'Tài khoản tiết kiệm',
            //     'is_active' => false,
            //     'auto_confirm' => false,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ]);
    }
}
