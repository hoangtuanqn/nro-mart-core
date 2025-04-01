<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RandomCategory;

class RandomCategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 1 danh mục cố định
        RandomCategory::create([
            'name' => 'Danh mục VIP',
            'slug' => 'danh-muc-vip',
            'thumbnail' => 'https://cdn3.upanh.info/upload/server-sw3/images/Valentine/Nick/Th%E1%BB%AD%20V%E1%BA%ADn%20May%20Ng%E1%BB%8Dc%20R%E1%BB%93ng%20Vip%203.jpg',
            'description' => 'Danh mục chứa các tài khoản cao cấp và giá trị.',
            'active' => true,
        ]);
    }
}