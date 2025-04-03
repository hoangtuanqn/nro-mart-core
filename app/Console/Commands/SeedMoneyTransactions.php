<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\MoneyTransactionSeeder;

class SeedMoneyTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:money-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed money transactions data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Seeding money transactions...');

        try {
            $seeder = new MoneyTransactionSeeder();
            $seeder->run();

            $this->info('Money transactions seeded successfully!');
        } catch (\Exception $e) {
            $this->error('Error seeding money transactions: ' . $e->getMessage());
        }
    }
}