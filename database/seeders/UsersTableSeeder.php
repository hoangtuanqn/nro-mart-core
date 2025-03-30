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
                'username' => 'htuanqn',
                'password' => Hash::make('Tuan2019@'), // Mật khẩu đã mã hóa
                'email' => 'anhquat644@example.com',
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
                'username' => 'member1',
                'password' => Hash::make('member123'),
                'email' => 'member1@example.com',
                'role' => 'member',
                'balance' => 50000,
                'total_deposited' => 200000,
                'banned' => false,
                'ip_address' => '192.168.1.2',
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'banned_user',
                'password' => Hash::make('banned123'),
                'email' => 'banned@example.com',
                'role' => 'member',
                'balance' => 0,
                'total_deposited' => 0,
                'banned' => true, // Tài khoản bị khóa
                'ip_address' => '192.168.1.3',
                'remember_token' => Str::random(10),
                'email_verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
