<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameAccountSeeder extends Seeder
{
    public function run()
    {
        DB::table('game_accounts')->insert([
            [
                'game_category_id' => 1,
                'account_name' => 'player1',
                'password' => bcrypt('password123'),
                'price' => 100000,
                'status' => 'available',
                'server' => 1,
                'registration_type' => 'virtual',
                'planet' => 'earth',
                'buyer_id' => null,
                'note' => 'Tài khoản VIP',
                'images' => json_encode([
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg"
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'game_category_id' => 1,
                'account_name' => 'player2',
                'password' => bcrypt('password456'),
                'price' => 150000,
                'status' => 'sold',
                'server' => 2,
                'registration_type' => 'real',
                'planet' => 'namek',
                'buyer_id' => 3,
                'note' => 'Đã bán cho user 3',
                'images' => json_encode([
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg"
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'game_category_id' => 1,
                'account_name' => 'player3',
                'password' => bcrypt('password789'),
                'price' => 200000,
                'status' => 'available',
                'server' => 3,
                'registration_type' => 'virtual',
                'planet' => 'xayda',
                'buyer_id' => null,
                'note' => 'Tài khoản mới',
                'images' => json_encode([
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg"
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'game_category_id' => 1,
                'account_name' => 'player4',
                'password' => bcrypt('password987'),
                'price' => 50000,
                'status' => 'sold',
                'server' => 4,
                'registration_type' => 'real',
                'planet' => 'earth',
                'buyer_id' => 2,
                'note' => 'Người chơi cấp 10',
                'images' => json_encode([
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg"
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'game_category_id' => 1,
                'account_name' => 'player5',
                'password' => bcrypt('password654'),
                'price' => 120000,
                'status' => 'available',
                'server' => 5,
                'registration_type' => 'virtual',
                'planet' => 'namek',
                'buyer_id' => null,
                'note' => 'Tài khoản mạnh',
                'images' => json_encode([
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg",
                    "https://img.acc957.com//20250328090315screenshot%202025-03-26%20091731.jpg"
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
