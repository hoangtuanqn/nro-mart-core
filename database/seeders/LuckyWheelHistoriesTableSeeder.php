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
use App\Models\LuckyWheelHistory;

class LuckyWheelHistoriesTableSeeder extends Seeder
{
    public function run(): void
    {

        $histories = [
            [
                'user_id' => 1, // Giả sử user_id = 1 tồn tại
                'lucky_wheel_id' => 1,
                'spin_count' => 3,
                'total_cost' => 30000,
                'reward_type' => 'gold',
                'reward_amount' => 500,
                'description' => 'Trúng 500 vàng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Giả sử user_id = 2 tồn tại
                'lucky_wheel_id' => 2,
                'spin_count' => 1,
                'total_cost' => 10000,
                'reward_type' => 'gem',
                'reward_amount' => 50,
                'description' => 'Trúng 50 ngọc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($histories as $history) {
            LuckyWheelHistory::create($history);
        }
    }
}