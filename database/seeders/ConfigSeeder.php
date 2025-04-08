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
            'site_keywords' => 'shop game, ngọc rồng, tài khoản game, game online, mua bán tài khoản game',
            'site_logo' => 'https://imgur.com/hIFVXRo.png',
            'site_logo_footer' => 'https://imgur.com/YAwjTGo.png',
            'site_share_image' => 'https://i.imgur.com/LFjJOxc.jpeg', // Ảnh hiển thị khi chia sẻ trên mạng xã hội
            'site_banner' => 'https://i.imgur.com/Z7OuMCq.png',
            'site_favicon' => 'https://i.imgur.com/J46gSIO.png',

            'address' => 'TPHCM, Việt Nam', // Cập nhật địa chỉ mới
            'phone' => $contactPhone,
            'email' => $contactEmail,

            // Social media settings
            'facebook' => 'https://facebook.com/tuanori.vn',
            'zalo' => $contactPhone, // Reusing phone number for Zalo
            'youtube' => 'https://www.youtube.com/@htuanqn',
            'discord' => 'https://discord.gg/example',
            'telegram' => 'https://t.me/example',
            'tiktok' => 'https://tiktok.com/@example',
            'working_hours' => '8:00 - 22:00',
            'home_notification' => 'Chào mừng bạn đến với Shop Bán Acc Game của chúng tôi. Nạp ATM/Momo khuyến mãi 10%, Nạp thẻ cào nhận 100% giá trị thẻ nạp !!',
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

            'payment.card.active' => '1',
            'payment.card.partner_website' => 'thesieure.com',
            'payment.card.partner_id' => '',
            'payment.card.partner_key' => '',
            'payment.card.discount_percent' => '20',
            'payment.bank.active' => '1',
            'payment.momo.active' => '1',
            // Login social settings (stored as JSON)
            'login_social.google.active' => '0',
            'login_social.google.client_id' => '',
            'login_social.google.client_secret' => '',
            'login_social.google.redirect' => '',
            'login_social.facebook.active' => '0',
            'login_social.facebook.client_id' => '',
            'login_social.facebook.client_secret' => '',
            'login_social.facebook.redirect' => '',
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
