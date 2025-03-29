<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameServicesSeeder extends Seeder
{
    public function run()
    {
        DB::table('game_services')->insert([
            'name' => 'Úp bí kiếp',
            'slug' => 'up-bi-kiep',
            'thumbnail' => 'https://acc957.com/Img/NRO_UBK.png',
            'description' => 'Dịch vụ up bí kiếp chuyên nghiệp, hỗ trợ mọi loại tài khoản',
            'type' => 'leveling',
            'active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}