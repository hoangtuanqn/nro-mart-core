<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ConfigController extends Controller
{
    /**
     * Hiển thị và cập nhật cài đặt chung
     */
    public function general()
    {
        $title = 'Cài đặt chung';

        // Lấy tất cả cấu hình chung
        $configs = [
            'site_name' => config_get('site_name', 'Shop Game Ngọc Rồng'),
            'site_description' => config_get('site_description', 'Mua bán tài khoản game Ngọc Rồng'),
            'site_logo' => config_get('site_logo'),
            'site_favicon' => config_get('site_favicon'),
            'address' => config_get('address', ''),
            'phone' => config_get('phone', ''),
            'email' => config_get('email', ''),
            'facebook' => config_get('facebook', ''),
            'zalo' => config_get('zalo', ''),
        ];

        return view('admin.settings.general', compact('title', 'configs'));
    }

    /**
     * Cập nhật cài đặt chung
     */
    public function updateGeneral(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'facebook' => 'nullable|string|max:255',
            'zalo' => 'nullable|string|max:20',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_favicon' => 'nullable|image|mimes:ico,png|max:1024',
        ]);

        // Xử lý upload logo nếu có
        if ($request->hasFile('site_logo')) {
            $logo = $request->file('site_logo');
            $logoName = 'logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('assets/img'), $logoName);
            config_set('site_logo', asset('assets/img/' . $logoName));
        }

        // Xử lý upload favicon nếu có
        if ($request->hasFile('site_favicon')) {
            $favicon = $request->file('site_favicon');
            $faviconName = 'favicon.' . $favicon->getClientOriginalExtension();
            $favicon->move(public_path('assets/img'), $faviconName);
            config_set('site_favicon', asset('assets/img/' . $faviconName));
        }

        // Cập nhật các cài đặt khác
        config_set('site_name', $request->site_name);
        config_set('site_description', $request->site_description);
        config_set('address', $request->address);
        config_set('phone', $request->phone);
        config_set('email', $request->email);
        config_set('facebook', $request->facebook);
        config_set('zalo', $request->zalo);

        // Xóa cache để cập nhật cài đặt
        config_clear_cache();

        return redirect()->route('admin.settings.general')
            ->with('success', 'Cài đặt chung đã được cập nhật thành công.');
    }

    /**
     * Hiển thị và cập nhật cài đặt email
     */
    public function email()
    {
        $title = 'Cài đặt email';

        // Lấy tất cả cấu hình email
        $configs = [
            'mail_mailer' => config_get('mail_mailer', 'smtp'),
            'mail_host' => config_get('mail_host', 'smtp.gmail.com'),
            'mail_port' => config_get('mail_port', '587'),
            'mail_username' => config_get('mail_username', ''),
            'mail_password' => config_get('mail_password', ''),
            'mail_encryption' => config_get('mail_encryption', 'tls'),
            'mail_from_address' => config_get('mail_from_address', ''),
            'mail_from_name' => config_get('mail_from_name', 'Shop Game Ngọc Rồng'),
        ];

        return view('admin.settings.email', compact('title', 'configs'));
    }

    /**
     * Cập nhật cài đặt email
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'required|string|in:smtp,sendmail,mailgun,ses,postmark,log,array',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|numeric',
            'mail_username' => 'required|string|max:255',
            'mail_password' => 'required|string',
            'mail_encryption' => 'required|string|in:tls,ssl,null',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
        ]);

        // Cập nhật cài đặt email
        config_set('mail_mailer', $request->mail_mailer);
        config_set('mail_host', $request->mail_host);
        config_set('mail_port', $request->mail_port);
        config_set('mail_username', $request->mail_username);
        config_set('mail_password', $request->mail_password);
        config_set('mail_encryption', $request->mail_encryption);
        config_set('mail_from_address', $request->mail_from_address);
        config_set('mail_from_name', $request->mail_from_name);

        // Xóa cache để cập nhật cài đặt
        config_clear_cache();

        return redirect()->route('admin.settings.email')
            ->with('success', 'Cài đặt email đã được cập nhật thành công.');
    }

    /**
     * Hiển thị và cập nhật cài đặt thanh toán
     */
    public function payment()
    {
        $title = 'Cài đặt thanh toán';

        // Lấy tất cả cấu hình thanh toán
        $configs = [
            // Cài đặt nạp thẻ cào
            'card_active' => config_get('payment.card.active', true),
            'partner_id_card' => config_get('payment.card.partner_id', ''),
            'partner_key_card' => config_get('payment.card.partner_key', ''),
        ];

        return view('admin.settings.payment', compact('title', 'configs'));
    }

    /**
     * Cập nhật cài đặt thanh toán
     */
    public function updatePayment(Request $request)
    {
        $request->validate([
            'card_active' => 'nullable|boolean',
            'partner_id_card' => 'nullable|string|max:100',
            'partner_key_card' => 'nullable|string|max:100',
        ]);

        // Nạp thẻ cào
        config_set('payment.card.active', $request->has('card_active') ? 1 : 0);
        config_set('payment.card.partner_id', $request->partner_id_card);
        config_set('payment.card.partner_key', $request->partner_key_card);

        // Xóa cache để cập nhật cài đặt
        config_clear_cache();

        return redirect()->route('admin.settings.payment')
            ->with('success', 'Cài đặt thanh toán đã được cập nhật thành công.');
    }
}
