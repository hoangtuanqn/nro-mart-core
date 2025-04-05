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
        $siteName = 'TUANORI.VN - Shop Game Ngọc Rồng';
        $siteDescription = 'Shop Ngọc Rồng Online cung cấp tài khoản game chính hãng, giá tốt nhất thị trường. Giao dịch an toàn, nhanh chóng và bảo mật';
        $contactEmail = 'support@tuanori.vn';
        $contactPhone = '0812665001';

        $configs = [
            // General settings
            'site_name' => $siteName,
            'site_description' => $siteDescription,
            'site_logo' => 'https://imgur.com/hIFVXRo.png',
            'site_logo_footer' => 'https://imgur.com/YAwjTGo.png',
            'site_banner' => 'https://123nick.vn/upload-usr/images/8jElw7OK4i_1629517832.gif',
            'site_favicon' => 'https://i.postimg.cc/sg1tCBGL/favicon.png',
            'address' => 'TPHCM, Việt Nam', // Cập nhật địa chỉ mới
            'phone' => $contactPhone,
            'email' => $contactEmail,

            // Social media settings
            'facebook' => 'https://facebook.com/example',
            'zalo' => $contactPhone, // Reusing phone number for Zalo
            'youtube' => 'https://www.youtube.com/@htuanqn',
            'discord' => 'https://discord.gg/example',
            'telegram' => 'https://t.me/example',
            'tiktok' => 'https://tiktok.com/@example',
            'working_hours' => '8:00 - 22:00',
            'home_notification' => 'Chào mừng bạn đến với Shop Ngọc Rồng Online. Nạp ATM/Momo khuyến mãi 10%, Nạp thẻ cào nhận 100% giá trị thẻ nạp !!!',
            'welcome_modal' => true, // Enable welcome modal by default

            // Email settings
            'mail_mailer' => 'smtp',
            'mail_host' => 'smtp.gmail.com',
            'mail_port' => '587',
            'mail_username' => '',
            'mail_password' => '',
            'mail_encryption' => 'tls',
            'mail_from_address' => $contactEmail, // Reusing contact email
            'mail_from_name' => $siteName, // Reusing site name

            // Payment settings (stored as JSON)
            'payment' => json_encode([
                'card' => [
                    'active' => '1',
                    'partner_website' => 'thesieure.com',
                    'partner_id' => '',
                    'partner_key' => '',
                    'discount_percent' => '20',
                ],
            ]),
            // Login social settings (stored as JSON)
            'login_social' => json_encode([
                'google' => [
                    'active' => '1',
                    'client_id' => '695655624016-tnn916t7g53oqulsiq0d9vvn7bof1568.apps.googleusercontent.com',
                    'client_secret' => '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',
                    'redirect' => 'http://localhost:8000/auth/google/callback',
                ],
                'facebook' => [
                    'active' => '1',
                    'client_id' => '713944317580357',
                    'client_secret' => '481beed7538a8b7318c45e94401f4e3c',
                    'redirect' => 'http://localhost:8000/auth/facebook/callback',
                ],
            ]),
        ];

        // Process and save the configs
        $this->saveConfigs(configs: $configs);
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
