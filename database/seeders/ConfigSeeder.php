<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define base values to avoid duplication
        $siteName = 'Shop Game Ngọc Rồng';
        $siteDescription = 'Mua bán tài khoản game Ngọc Rồng';
        $contactEmail = 'contact@example.com';
        $contactPhone = '0123456789';

        $configs = [
            // General settings
            'site_name' => $siteName,
            'site_description' => $siteDescription,
            'site_logo' => '',
            'site_favicon' => '',
            'address' => 'Hà Nội, Việt Nam',
            'phone' => $contactPhone,
            'email' => $contactEmail,
            'facebook' => 'https://facebook.com/example',
            'zalo' => $contactPhone, // Reusing phone number for Zalo

            // Email settings
            'mail_mailer' => 'smtp',
            'mail_host' => 'smtp.gmail.com',
            'mail_port' => '587',
            'mail_username' => '',
            'mail_password' => '',
            'mail_encryption' => 'tls',
            'mail_from_address' => $contactEmail, // Reusing contact email
            'mail_from_name' => $siteName, // Reusing site name

            // Payment settings
            'payment' => [
                'card' => [
                    'active' => '1',
                    'partner_id' => '',
                    'partner_key' => '',
                ],
            ],
        ];

        // Process and save the configs
        $this->saveConfigs($configs);
    }

    /**
     * Save configs recursively
     */
    private function saveConfigs($configs, $prefix = '')
    {
        foreach ($configs as $key => $value) {
            $fullKey = $prefix ? $prefix . '.' . $key : $key;

            if (is_array($value)) {
                // If value is an array, process it recursively
                $this->saveConfigs($value, $fullKey);
            } else {
                // Save the config value
                Config::updateOrCreate(
                    ['key' => $fullKey],
                    ['value' => $value]
                );
            }
        }
    }
}
