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

class GameServicesSeeder extends Seeder
{
    public function run()
    {
        DB::table('game_services')->insert([
            [
                'name' => 'ÚP BÍ KIẾP',
                'slug' => Str::slug('ÚP BÍ KIẾP'),
                'thumbnail' => 'https://i.postimg.cc/g0WLJcxH/NRO-UBK.png',
                'description' => 'Dịch vụ up bí kiếp chuyên nghiệp, hỗ trợ mọi loại tài khoản',
                'type' => 'leveling',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'SĂN ĐỆ TỬ',
                'slug' => Str::slug('SĂN ĐỆ TỬ'),
                'thumbnail' => 'https://i.postimg.cc/prpp7pSR/NRO-SDT.png',
                'description' => 'Dịch vụ săn đệ tử, giúp người chơi tìm kiếm và thu phục đệ tử mạnh mẽ.',
                'type' => 'leveling',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'UP SỨC MẠNH ĐỆ TỬ',
                'slug' => Str::slug('UP SỨC MẠNH ĐỆ TỬ'),
                'thumbnail' => 'https://i.postimg.cc/sXnMwpwT/NRO-USMDT.png',
                'description' => 'Dịch vụ nâng cấp sức mạnh cho đệ tử, giúp họ trở nên mạnh mẽ hơn.',
                'type' => 'leveling',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'LÀM NHIỆM VỤ',
                'slug' => Str::slug('LÀM NHIỆM VỤ'),
                'thumbnail' => 'https://i.postimg.cc/nzVs4dYs/NRO-LNV.png',
                'description' => 'Dịch vụ hỗ trợ hoàn thành nhiệm vụ trong game, giúp người chơi nhanh chóng đạt được mục tiêu.',
                'type' => 'leveling',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}