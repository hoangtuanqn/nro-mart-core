<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LuckyWheelHistory;
use App\Models\LuckyWheel;

class LuckyWheelHistoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $luckyWheelId = LuckyWheel::where('slug', 'vong-quay-vip')->first()->id;

        $histories = [
            [
                'user_id' => 1, // Giả sử user_id = 1 tồn tại
                'lucky_wheel_id' => $luckyWheelId,
                'spin_count' => 3,
                'total_cost' => 30000,
                'reward_type' => 'gold',
                'reward_amount' => 500,
                'description' => 'Trúng 500 vàng',
            ],
            [
                'user_id' => 2, // Giả sử user_id = 2 tồn tại
                'lucky_wheel_id' => $luckyWheelId,
                'spin_count' => 1,
                'total_cost' => 10000,
                'reward_type' => 'gem',
                'reward_amount' => 50,
                'description' => 'Trúng 50 ngọc',
            ],
        ];

        foreach ($histories as $history) {
            LuckyWheelHistory::create($history);
        }
    }
}