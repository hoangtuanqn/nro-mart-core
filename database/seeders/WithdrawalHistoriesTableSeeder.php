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
use App\Models\WithdrawalHistory;

class WithdrawalHistoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $withdrawals = [
            [
                'user_id' => 1, // Giả sử user_id = 1 tồn tại
                'amount' => 1000,
                'type' => 'gold',
                'character_name' => 'Hero123',
                'server' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Giả sử user_id = 2 tồn tại
                'amount' => 200,
                'type' => 'gem',
                'character_name' => 'MageXYZ',
                'server' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($withdrawals as $withdrawal) {
            WithdrawalHistory::create($withdrawal);
        }
    }
}