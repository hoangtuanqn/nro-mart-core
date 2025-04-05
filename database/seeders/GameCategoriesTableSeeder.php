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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GameCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('game_categories')->insert([
            [
                'name' => 'NICK HỒI SINH NGỌC RỒNG',
                'slug' => Str::slug('NICK HỒI SINH NGỌC RỒNG'), // Tạo slug tự động
                'thumbnail' => 'https://i.postimg.cc/qq3pynYh/20240215164859nickhsnr.jpg',
                'description' => 'Danh mục tài khoản hồi sinh trong Ngọc Rồng Online.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SƠ SINH + WIN DOANH TRẠI + ZIN',
                'slug' => Str::slug('SƠ SINH + WIN DOANH TRẠI + ZIN'), // Tạo slug tự động
                'thumbnail' => 'https://i.postimg.cc/qq3pynYh/20240215164859nickhsnr.jpg',
                'description' => 'Danh mục tài khoản sơ sinh với khả năng chiến thắng trong doanh trại.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NGỌC RỒNG NICK TẦM TRUNG',
                'slug' => Str::slug('NGỌC RỒNG NICK TẦM TRUNG'), // Tạo slug tự động
                'thumbnail' => 'https://i.postimg.cc/qq3pynYh/20240215164859nickhsnr.jpg',
                'description' => 'Danh mục tài khoản Ngọc Rồng tầm trung, phù hợp cho người chơi mới.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SHOP VẬT PHẨM',
                'slug' => Str::slug('SHOP VẬT PHẨM'), // Tạo slug tự động
                'thumbnail' => 'https://i.postimg.cc/Jzc4pNhj/NRO-ITEM.png',
                'description' => 'Danh mục cửa hàng vật phẩm trong Ngọc Rồng Online.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NICK CÓ ĐỆ SKILL 2 + THOÁT SƠ SINH',
                'slug' => Str::slug('NICK CÓ ĐỆ SKILL 2 + THOÁT SƠ SINH'), // Tạo slug tự động
                'thumbnail' => 'https://i.postimg.cc/Jzc4pNhj/NRO-ITEM.png',
                'description' => 'Danh mục tài khoản có đệ skill 2, phù hợp cho người chơi nâng cao.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
