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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make('admin123456'), // Mật khẩu đã mã hóa
                'email' => 'example@example.com',
                'role' => 'admin',
                'balance' => 1000000,
                'total_deposited' => 5000000,
                'banned' => false,
                'ip_address' => '192.168.1.1',
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'moderator',
                'password' => Hash::make('admin123456'), // Mật khẩu đã mã hóa
                'email' => 'moderator@example.com',
                'role' => 'admin',
                'balance' => 1000000,
                'total_deposited' => 5000000,
                'banned' => false,
                'ip_address' => '192.168.1.1',
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'username' => 'staff',
                'password' => Hash::make('admin123456'), // Mật khẩu đã mã hóa
                'email' => 'staff@example.com', 
                'role' => 'admin',
                'balance' => 1000000,
                'total_deposited' => 5000000,
                'banned' => false,
                'ip_address' => '192.168.1.1',
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
