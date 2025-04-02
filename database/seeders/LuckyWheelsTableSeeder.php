<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LuckyWheel;

class LuckyWheelsTableSeeder extends Seeder
{
    public function run(): void
    {
        LuckyWheel::create([
            'name' => 'Vòng quay VIP',
            'slug' => 'vong-quay-vip',
            'thumbnail' => 'images/lucky_wheel_vip.jpg',
            'wheel_image' => 'images/lucky_wheel_vip.jpg',
            'rules' => '<p>Quay để nhận vàng hoặc ngọc. Mỗi lần quay tốn 10,000 VNĐ.</p>',
            'active' => true,
            'price_per_spin' => 10000,
            'config' => json_encode([
                ['type' => 'gold', 'content' => 'Trúng 500 vàng', 'amount' => 500],
                ['type' => 'gem', 'content' => 'Trúng 50 ngọc', 'amount' => 50],
                ['type' => 'gold', 'content' => 'Trúng 1000 vàng', 'amount' => 1000],
                ['type' => 'gem', 'content' => 'Trúng 100 ngọc', 'amount' => 100],
                ['type' => 'gold', 'content' => 'Trúng 200 vàng', 'amount' => 200],
                ['type' => 'gem', 'content' => 'Trúng 20 ngọc', 'amount' => 20],
                ['type' => 'gold', 'content' => 'Trúng 300 vàng', 'amount' => 300],
                ['type' => 'gem', 'content' => 'Chúc may mắn lần sau', 'amount' => 0],
            ]),
        ]);
    }
}