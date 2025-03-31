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
            'thumbnail' => 'images/vip_category.jpg',
            'description' => 'Danh mục chứa các tài khoản cao cấp và giá trị.',
            'active' => true,
        ]);
    }
}