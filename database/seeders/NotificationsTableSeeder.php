<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = now(); // Lấy thời gian hiện tại một lần để dùng chung

        $notifications = [
            [
                'class_favicon' => 'fa-user-circle', // Biểu tượng người dùng
                'content' => 'Tài khoản Ngọc Rồng chất lượng, đa dạng mức giá',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'class_favicon' => 'fa-credit-card', // Biểu tượng thẻ tín dụng
                'content' => 'Nạp thẻ tỷ lệ 1:1 (nhận 100% giá trị thẻ)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'class_favicon' => 'fa-money-bill-wave', // Biểu tượng tiền
                'content' => 'Nạp ATM/Momo khuyến mãi 10%',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'class_favicon' => 'fa-headset', // Biểu tượng hỗ trợ
                'content' => 'Hỗ trợ 24/7, giải quyết mọi vấn đề nhanh chóng',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Sử dụng insert để thêm tất cả bản ghi cùng lúc
        DB::table('notifications')->insert($notifications);
    }
}