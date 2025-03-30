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

        // Lấy tất cả cấu hình thanh toán bằng phương thức mới
        $vnpay = config_get_group('payment.vnpay');
        $momo = config_get_group('payment.momo');
        $bank = config_get_group('payment.bank_transfer');

        // Chuyển đổi sang định dạng cũ để tương thích với view
        $configs = [
            // Cài đặt thanh toán VNPay
            'vnpay_active' => $vnpay['active'] ?? false,
            'vnpay_terminal_id' => $vnpay['terminal_id'] ?? '',
            'vnpay_secret_key' => $vnpay['secret_key'] ?? '',

            // Cài đặt thanh toán Momo
            'momo_active' => $momo['active'] ?? false,
            'momo_partner_code' => $momo['partner_code'] ?? '',
            'momo_access_key' => $momo['access_key'] ?? '',
            'momo_secret_key' => $momo['secret_key'] ?? '',

            // Cài đặt chuyển khoản ngân hàng
            'bank_transfer_active' => $bank['active'] ?? true,
            'bank_name' => $bank['name'] ?? '',
            'bank_account_number' => $bank['account_number'] ?? '',
            'bank_account_name' => $bank['account_name'] ?? '',
            'bank_branch' => $bank['branch'] ?? '',
        ];

        return view('admin.settings.payment', compact('title', 'configs'));
    }

    /**
     * Cập nhật cài đặt thanh toán
     */
    public function updatePayment(Request $request)
    {
        $request->validate([
            'vnpay_active' => 'nullable|boolean',
            'vnpay_terminal_id' => 'nullable|string|max:50',
            'vnpay_secret_key' => 'nullable|string|max:100',

            'momo_active' => 'nullable|boolean',
            'momo_partner_code' => 'nullable|string|max:50',
            'momo_access_key' => 'nullable|string|max:100',
            'momo_secret_key' => 'nullable|string|max:100',

            'bank_transfer_active' => 'nullable|boolean',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_name' => 'nullable|string|max:100',
            'bank_branch' => 'nullable|string|max:255',
        ]);

        // VNPay
        config_set('payment.vnpay.active', $request->has('vnpay_active') ? 1 : 0);
        config_set('payment.vnpay.terminal_id', $request->vnpay_terminal_id);
        config_set('payment.vnpay.secret_key', $request->vnpay_secret_key);

        // Momo
        config_set('payment.momo.active', $request->has('momo_active') ? 1 : 0);
        config_set('payment.momo.partner_code', $request->momo_partner_code);
        config_set('payment.momo.access_key', $request->momo_access_key);
        config_set('payment.momo.secret_key', $request->momo_secret_key);

        // Chuyển khoản ngân hàng
        config_set('payment.bank_transfer.active', $request->has('bank_transfer_active') ? 1 : 0);
        config_set('payment.bank_transfer.name', $request->bank_name);
        config_set('payment.bank_transfer.account_number', $request->bank_account_number);
        config_set('payment.bank_transfer.account_name', $request->bank_account_name);
        config_set('payment.bank_transfer.branch', $request->bank_branch);

        // Xóa cache để cập nhật cài đặt
        config_clear_cache();

        return redirect()->route('admin.settings.payment')
            ->with('success', 'Cài đặt thanh toán đã được cập nhật thành công.');
    }
}
