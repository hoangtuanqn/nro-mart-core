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

class ServicePackagesSeeder extends Seeder
{
    public function run()
    {
        $serviceId = DB::table('game_services')
            ->where('slug', 'up-bi-kiep')
            ->value('id');

        $packages = [
            [
                'game_service_id' => $serviceId,
                'name' => 'Tiêu Diệt Fide',
                'price' => 40000,
                'estimated_time' => 60,
                'description' => 'Cứ thuê acc như thế nào shop cũng làm được',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'game_service_id' => $serviceId,
                'name' => 'Apk 13, 14, 15',
                'price' => 40000,
                'estimated_time' => 60,
                'description' => 'Cứ thuê acc như thế nào shop cũng làm được',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'game_service_id' => $serviceId,
                'name' => 'Apk 19, 20',
                'price' => 60000,
                'estimated_time' => 90,
                'description' => 'Cứ thuê acc như thế nào shop cũng làm được',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'game_service_id' => $serviceId,
                'name' => 'Plc, Poc, King Kong',
                'price' => 60000,
                'estimated_time' => 90,
                'description' => 'Cứ thuê acc như thế nào shop cũng làm được',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'game_service_id' => $serviceId,
                'name' => 'Xbh 1, 2, hoàn thiện',
                'price' => 100000,
                'estimated_time' => 120,
                'description' => 'Cứ thuê acc như thế nào shop cũng làm được',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'game_service_id' => $serviceId,
                'name' => 'Tiểu Đội Sát Thủ',
                'price' => 100000,
                'estimated_time' => 120,
                'description' => 'Cứ thuê acc như thế nào cũng làm được',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'game_service_id' => $serviceId,
                'name' => 'Siêu bọ hung',
                'price' => 120000,
                'estimated_time' => 150,
                'description' => 'Cứ thuê acc như thế nào shop cũng làm được',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('service_packages')->insert($packages);
    }
}
