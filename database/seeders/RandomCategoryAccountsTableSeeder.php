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
use App\Models\RandomCategoryAccount;
use App\Models\RandomCategory;

class RandomCategoryAccountsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy ID của danh mục vừa tạo

        // Tạo 10 tài khoản cố định
        $accounts = [
            [
                'random_category_id' => 1,
                'account_name' => 'player1',
                'password' => 'pass123',
                'price' => 500000,
                'status' => 'available',
                'server' => 1,
                'buyer_id' => null,
                'note' => 'Tài khoản cấp 50.',
                'thumbnail' => 'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'random_category_id' => 1,
                'account_name' => 'player2',
                'password' => 'pass456',
                'price' => 750000,
                'status' => 'sold',
                'server' => 2,
                'buyer_id' => 1, // Giả sử đã có user_id = 1
                'note' => 'Tài khoản có skin hiếm.',
                'thumbnail' => 'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'random_category_id' => 1,
                'account_name' => 'player3',
                'password' => 'pass789',
                'price' => 300000,
                'status' => 'available',
                'server' => 3,
                'buyer_id' => null,
                'note' => null,
                'thumbnail' => 'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'random_category_id' => 1,
                'account_name' => null,
                'password' => null,
                'price' => 1000000,
                'status' => 'available',
                'server' => 4,
                'buyer_id' => null,
                'note' => 'Tài khoản đặc biệt.',
                'thumbnail' => 'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'random_category_id' => 1,
                'account_name' => 'player5',
                'password' => 'pass101',
                'price' => 450000,
                'status' => 'sold',
                'server' => 5,
                'buyer_id' => 2, // Giả sử đã có user_id = 2
                'note' => null,
                'thumbnail' => 'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'random_category_id' => 1,
                'account_name' => 'player6',
                'password' => 'pass202',
                'price' => 600000,
                'status' => 'available',
                'server' => 6,
                'buyer_id' => null,
                'note' => 'Tài khoản VIP.',
                'thumbnail' => 'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'random_category_id' => 1,
                'account_name' => 'player7',
                'password' => 'pass303',
                'price' => 800000,
                'status' => 'available',
                'server' => 7,
                'buyer_id' => null,
                'note' => null,
                'thumbnail' => 'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'random_category_id' => 1,
                'account_name' => 'player8',
                'password' => 'pass404',
                'price' => 250000,
                'status' => 'sold',
                'server' => 8,
                'buyer_id' => 3, // Giả sử đã có user_id = 3
                'note' => 'Tài khoản đã qua sử dụng.',
                'thumbnail' => 'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'random_category_id' => 1,
                'account_name' => 'player9',
                'password' => 'pass505',
                'price' => 350000,
                'status' => 'available',
                'server' => 9,
                'buyer_id' => null,
                'note' => null,
                'thumbnail' => 'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'random_category_id' => 1,
                'account_name' => 'player10',
                'password' => 'pass606',
                'price' => 900000,
                'status' => 'available',
                'server' => 10,
                'buyer_id' => null,
                'note' => 'Tài khoản cao cấp nhất.',
                'thumbnail' => 'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpgg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Thêm từng tài khoản vào cơ sở dữ liệu
        foreach ($accounts as $account) {
            RandomCategoryAccount::create($account);
        }
    }
}