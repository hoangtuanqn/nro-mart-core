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
use App\Models\RandomCategory;
use Illuminate\Support\Str;

class RandomCategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 1 danh mục cố định
        RandomCategory::insert([
            [
                'name' => 'THỬ VẬN MAY NGỌC RỒNG VIP 1',
                'slug' => Str::slug('THỬ VẬN MAY NGỌC RỒNG VIP 1'),
                'thumbnail' => 'https://i.postimg.cc/htqt8yKS/Th-V-n-May-Ng-c-R-ng-Vip-1.jpg',
                'description' => 'Danh mục chứa tài khoản thử vận may Ngọc Rồng VIP 1.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'THỬ VẬN MAY NGỌC RỒNG VIP 2',
                'slug' => Str::slug('THỬ VẬN MAY NGỌC RỒNG VIP 2'),
                'thumbnail' => 'https://i.postimg.cc/8PvC6QQK/Th-V-n-May-Ng-c-R-ng-Vip-2.jpg',
                'description' => 'Danh mục chứa tài khoản thử vận may Ngọc Rồng VIP 2.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'THỬ VẬN MAY NGỌC RỒNG VIP 3',
                'slug' => Str::slug('THỬ VẬN MAY NGỌC RỒNG VIP 3'),
                'thumbnail' => 'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpg',
                'description' => 'Danh mục chứa tài khoản thử vận may Ngọc Rồng VIP 3.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}