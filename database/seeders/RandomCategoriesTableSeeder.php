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
                'thumbnail' => 'https://cdn3.upanh.info/upload/server-sw3/images/Qu%E1%BB%91c%20t%E1%BA%BF%20ph%E1%BB%A5%20n%E1%BB%AF/Nick/Th%E1%BB%AD%20V%E1%BA%ADn%20May%20Ng%E1%BB%8Dc%20R%E1%BB%93ng%20Vip%201.jpg',
                'description' => 'Danh mục chứa tài khoản thử vận may Ngọc Rồng VIP 1.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'THỬ VẬN MAY NGỌC RỒNG VIP 2',
                'slug' => Str::slug('THỬ VẬN MAY NGỌC RỒNG VIP 2'),
                'thumbnail' => 'https://cdn3.upanh.info/upload/server-sw3/images/Qu%E1%BB%91c%20t%E1%BA%BF%20ph%E1%BB%A5%20n%E1%BB%AF/Nick/Th%E1%BB%AD%20V%E1%BA%ADn%20May%20Ng%E1%BB%8Dc%20R%E1%BB%93ng%20Vip%202.jpg',
                'description' => 'Danh mục chứa tài khoản thử vận may Ngọc Rồng VIP 2.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'THỬ VẬN MAY NGỌC RỒNG VIP 3',
                'slug' => Str::slug('THỬ VẬN MAY NGỌC RỒNG VIP 3'),
                'thumbnail' => 'https://cdn3.upanh.info/upload/server-sw3/images/Qu%E1%BB%91c%20t%E1%BA%BF%20ph%E1%BB%A5%20n%E1%BB%AF/Nick/Th%E1%BB%AD%20V%E1%BA%ADn%20May%20Ng%E1%BB%8Dc%20R%E1%BB%93ng%20Vip%203.jpg',
                'description' => 'Danh mục chứa tài khoản thử vận may Ngọc Rồng VIP 3.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}