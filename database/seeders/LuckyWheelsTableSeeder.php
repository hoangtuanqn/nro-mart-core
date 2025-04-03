<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LuckyWheel;

class LuckyWheelsTableSeeder extends Seeder
{
    public function run(): void
    {
        LuckyWheel::create([
            'wheel_type' => 'upload',
            'name' => 'Vòng quay VIP',
            'slug' => 'vong-quay-vip',
            'thumbnail' => 'https://123nick.vn/upload-usr/images/uKLBfY8jWr_1630159016.gif',
            'wheel_image' => 'https://123nick.vn/upload-usr/images/LVNwJbtFqU_1599464163.jpg',
            'rules' => '<p>Quay để nhận vàng hoặc ngọc. Mỗi lần quay tốn 10,000 VNĐ.</p>',
            'active' => true,
            'price_per_spin' => 10000,
            'config' => json_encode([
                ['type' => 'gold', 'content' => 'Trúng 500 vàng', 'amount' => 500, 'probability' => 25],
                ['type' => 'gem', 'content' => 'Trúng 50 ngọc', 'amount' => 50, 'probability' => 25],
                ['type' => 'gold', 'content' => 'Trúng 1000 vàng', 'amount' => 1000, 'probability' => 25],
                ['type' => 'gem', 'content' => 'Trúng 100 ngọc', 'amount' => 100, 'probability' => 25],
                ['type' => 'gold', 'content' => 'Trúng 200 vàng', 'amount' => 200, 'probability' => 25],
                ['type' => 'gem', 'content' => 'Trúng 20 ngọc', 'amount' => 20, 'probability' => 25],
                ['type' => 'gold', 'content' => 'Trúng 300 vàng', 'amount' => 300, 'probability' => 25],
                ['type' => 'gem', 'content' => 'Chúc may mắn lần sau', 'amount' => 0, 'probability' => 25],
            ]),
        ]);
    }
}