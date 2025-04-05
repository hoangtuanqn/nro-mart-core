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
use App\Models\LuckyWheel;
use Illuminate\Support\Str;

class LuckyWheelsTableSeeder extends Seeder
{
    public function run(): void
    {
        LuckyWheel::insert([
            [
                'name' => 'Vòng Quay Vàng',
                'slug' => Str::slug('Vòng Quay Vàng'),
                'thumbnail' => 'https://i.postimg.cc/xTNX3NHP/u-KLBf-Y8j-Wr-1630159016.gif',
                'wheel_image' => 'https://img.upanh.tv/2025/04/03/LVNwJbtFqU_1599464163-removebg-preview6c5e709413be5b98.png',
                'description' => 'Bạn có thể tham gia vòng quay để có cơ hội nhận được vàng hoặc ngọc. Mỗi lần bạn quay sẽ tốn 10,000 VNĐ, và đây là một cơ hội tuyệt vời để thử vận may của mình. Hãy tham gia ngay để không bỏ lỡ những phần thưởng hấp dẫn đang chờ đón bạn.',
                'rules' => '<p>Quay để nhận vàng hoặc ngọc. Mỗi lần quay tốn 10,000 VNĐ.</p>',
                'active' => true,
                'price_per_spin' => 10000,
                'config' => json_encode([
                    ['type' => 'gold', 'content' => 'Trúng 1 tỷ vàng', 'amount' => 1000000000, 'probability' => 10],
                    ['type' => 'gold', 'content' => 'Trúng 50 triệu vàng', 'amount' => 50000000, 'probability' => 15],
                    ['type' => 'gold', 'content' => 'Trúng 75 triệu vàng', 'amount' => 75000000, 'probability' => 20],
                    ['type' => 'gold', 'content' => 'Trúng 100 triệu vàng', 'amount' => 100000000, 'probability' => 25],
                    ['type' => 'gold', 'content' => 'Trúng 130 triệu vàng', 'amount' => 130000000, 'probability' => 10],
                    ['type' => 'gold', 'content' => 'Trúng 200 triệu vàng', 'amount' => 200000000, 'probability' => 5],
                    ['type' => 'gold', 'content' => 'Trúng 250 triệu vàng', 'amount' => 250000000, 'probability' => 5],
                    ['type' => 'gold', 'content' => 'Trúng 500 triệu vàng', 'amount' => 500000000, 'probability' => 10],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vòng Quay Ngọc',
                'slug' => Str::slug('Vòng Quay Ngọc'),
                'thumbnail' => 'https://i.postimg.cc/vZWDpR0g/z5986105444643-1bf089311b9e3a012cb4659a7e46fd7c.gif',
                'wheel_image' => 'https://i.postimg.cc/vmbDyPKP/spinTYOI.png',
                'description' => 'Quay để nhận vàng hoặc ngọc. Mỗi lần quay sẽ tốn 10,000 VNĐ. Hãy tham gia để có cơ hội nhận được những phần thưởng giá trị từ vòng quay này. Mỗi lượt quay sẽ mang đến cho bạn những trải nghiệm thú vị và cơ hội trúng thưởng hấp dẫn.',

                'rules' => '<p>Quay để nhận vàng hoặc ngọc. Mỗi lần quay tốn 10,000 VNĐ.</p>',
                'active' => true,
                'price_per_spin' => 10000,
                'config' => json_encode([
                    ['type' => 'gem', 'content' => 'Trúng 5000 ngọc', 'amount' => 5000, 'probability' => 10],
                    ['type' => 'gem', 'content' => 'Trúng 50 ngọc', 'amount' => 50, 'probability' => 15],
                    ['type' => 'gem', 'content' => 'Trúng 100 ngọc', 'amount' => 100, 'probability' => 20],
                    ['type' => 'gem', 'content' => 'Trúng 150 ngọc', 'amount' => 150, 'probability' => 25],
                    ['type' => 'gem', 'content' => 'Trúng 200 ngọc', 'amount' => 200, 'probability' => 10],
                    ['type' => 'gem', 'content' => 'Trúng 300 ngọc', 'amount' => 300, 'probability' => 10],
                    ['type' => 'gem', 'content' => 'Trúng 500 ngọc', 'amount' => 500, 'probability' => 5],
                    ['type' => 'gem', 'content' => 'Trúng 1000 ngọc', 'amount' => 1000, 'probability' => 5],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}