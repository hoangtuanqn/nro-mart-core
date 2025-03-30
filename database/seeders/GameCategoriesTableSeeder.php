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
                'thumbnail' => 'http://img.acc957.com/20240215164859nickhsnr.jpg',
                'description' => 'Đây là danh mục các tài khoản hồi sinh trong Ngọc Rồng Online.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
