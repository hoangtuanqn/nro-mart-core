<?php

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
        $configs = [
            // Thông tin chung của website
            ['key' => 'site_title', 'value' => 'Shop bán acc game'],
            ['key' => 'site_description', 'value' => 'Mua bán tài khoản game an toàn, uy tín, giá tốt nhất. Hệ thống tự động giao dịch, hỗ trợ khách hàng 24/7.'],
            ['key' => 'site_keywords', 'value' => 'mua acc game, bán acc game, shop acc game, tài khoản game giá rẻ, mua bán game account'],

            // Thông tin liên hệ
            ['key' => 'contact_facebook', 'value' => 'https://facebook.com/shopbanaccgame'],
            ['key' => 'contact_youtube', 'value' => 'https://youtube.com/@shopbanaccgame'],
            ['key' => 'contact_phone', 'value' => '0912912912'],
            ['key' => 'contact_address', 'value' => '123 Đường ABC, Quận XYZ, TP.HCM'],
            ['key' => 'contact_discord', 'value' => 'https://discord.gg/accgame'],
            ['key' => 'contact_tiktok', 'value' => 'https://tiktok.com/@shopbanaccgame'],
            ['key' => 'contact_email', 'value' => 'support@shopbanaccgame.com'],

            // Cấu hình nạp tiền
            ['key' => 'deposit_prefix', 'value' => 'NAPTIEN_'],
            ['key' => 'deposit_discount', 'value' => '20'], // Chiết khấu 20%

            // Cấu hình thanh toán đối tác qua THESIEURE, CARDVIP, ...
            ['key' => 'partner_id', 'value' => '9833246561'],
            ['key' => 'partner_key', 'value' => '2dea0df5c1a12a48b14141f0c0301bc6'],

            // Cấu hình email
            ['key' => 'email_smtp_host', 'value' => 'smtp.example.com'],
            ['key' => 'email_smtp_port', 'value' => '587'],
            ['key' => 'email_smtp_user', 'value' => 'noreply@shopbanaccgame.com'],
            ['key' => 'email_smtp_password', 'value' => 'your_email_password'],

            // Bản quyền hệ thống
            ['key' => 'license_key', 'value' => 'ABC123-XYZ789-MNB456'],
        ];

        // Chạy vòng lặp để insert hoặc update dữ liệu vào bảng configs
        foreach ($configs as $config) {
            Config::updateOrCreate(['key' => $config['key']], ['value' => $config['value']]);
        }
    }
}
