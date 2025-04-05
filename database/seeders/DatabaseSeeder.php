<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

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
            ConfigSeeder::class,
            RandomCategoriesTableSeeder::class,
            RandomCategoryAccountsTableSeeder::class,
            LuckyWheelsTableSeeder::class,
            LuckyWheelHistoriesTableSeeder::class,
            WithdrawalHistoriesTableSeeder::class,
            MoneyWithdrawalHistoriesTableSeeder::class,
            BankAccountSeeder::class,
            NotificationsTableSeeder::class,
        ]);
        //php artisan migrate
        // php artisan db:seed
        // php artisan migrate --seed
    }
}
// Chạy câu lệnh: php artisan db:seed
