<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            GameCategoriesTableSeeder::class,
            GameAccountSeeder::class,
            GameServicesSeeder::class,
            ServicePackagesSeeder::class,
        ]);
    }
}
// Chạy câu lệnh: php artisan db:seed