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
            'site_name' => $this->getConfig('site_name', 'Shop Game Ngọc Rồng'),
            'site_description' => $this->getConfig('site_description', 'Mua bán tài khoản game Ngọc Rồng'),
            'site_logo' => $this->getConfig('site_logo'),
            'site_favicon' => $this->getConfig('site_favicon'),
            'currency' => $this->getConfig('currency', 'VND'),
            'address' => $this->getConfig('address', ''),
            'phone' => $this->getConfig('phone', ''),
            'email' => $this->getConfig('email', ''),
            'facebook' => $this->getConfig('facebook', ''),
            'zalo' => $this->getConfig('zalo', ''),
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
            'currency' => 'required|string|max:10',
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
            $this->setConfig('site_logo', asset('assets/img/' . $logoName));
        }

        // Xử lý upload favicon nếu có
        if ($request->hasFile('site_favicon')) {
            $favicon = $request->file('site_favicon');
            $faviconName = 'favicon.' . $favicon->getClientOriginalExtension();
            $favicon->move(public_path('assets/img'), $faviconName);
            $this->setConfig('site_favicon', asset('assets/img/' . $faviconName));
        }

        // Cập nhật các cài đặt khác
        $this->setConfig('site_name', $request->site_name);
        $this->setConfig('site_description', $request->site_description);
        $this->setConfig('currency', $request->currency);
        $this->setConfig('address', $request->address);
        $this->setConfig('phone', $request->phone);
        $this->setConfig('email', $request->email);
        $this->setConfig('facebook', $request->facebook);
        $this->setConfig('zalo', $request->zalo);

        // Xóa cache để cập nhật cài đặt
        $this->clearConfigCache();

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
            'mail_mailer' => $this->getConfig('mail_mailer', 'smtp'),
            'mail_host' => $this->getConfig('mail_host', 'smtp.gmail.com'),
            'mail_port' => $this->getConfig('mail_port', '587'),
            'mail_username' => $this->getConfig('mail_username', ''),
            'mail_password' => $this->getConfig('mail_password', ''),
            'mail_encryption' => $this->getConfig('mail_encryption', 'tls'),
            'mail_from_address' => $this->getConfig('mail_from_address', ''),
            'mail_from_name' => $this->getConfig('mail_from_name', 'Shop Game Ngọc Rồng'),
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
        $this->setConfig('mail_mailer', $request->mail_mailer);
        $this->setConfig('mail_host', $request->mail_host);
        $this->setConfig('mail_port', $request->mail_port);
        $this->setConfig('mail_username', $request->mail_username);
        $this->setConfig('mail_password', $request->mail_password);
        $this->setConfig('mail_encryption', $request->mail_encryption);
        $this->setConfig('mail_from_address', $request->mail_from_address);
        $this->setConfig('mail_from_name', $request->mail_from_name);

        // Xóa cache để cập nhật cài đặt
        $this->clearConfigCache();

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
            // Cài đặt thanh toán VNPay
            'vnpay_active' => $this->getConfig('vnpay_active', false),
            'vnpay_terminal_id' => $this->getConfig('vnpay_terminal_id', ''),
            'vnpay_secret_key' => $this->getConfig('vnpay_secret_key', ''),

            // Cài đặt thanh toán Momo
            'momo_active' => $this->getConfig('momo_active', false),
            'momo_partner_code' => $this->getConfig('momo_partner_code', ''),
            'momo_access_key' => $this->getConfig('momo_access_key', ''),
            'momo_secret_key' => $this->getConfig('momo_secret_key', ''),

            // Cài đặt chuyển khoản ngân hàng
            'bank_transfer_active' => $this->getConfig('bank_transfer_active', true),
            'bank_name' => $this->getConfig('bank_name', ''),
            'bank_account_number' => $this->getConfig('bank_account_number', ''),
            'bank_account_name' => $this->getConfig('bank_account_name', ''),
            'bank_branch' => $this->getConfig('bank_branch', ''),
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
        $this->setConfig('vnpay_active', $request->has('vnpay_active') ? 1 : 0);
        $this->setConfig('vnpay_terminal_id', $request->vnpay_terminal_id);
        $this->setConfig('vnpay_secret_key', $request->vnpay_secret_key);

        // Momo
        $this->setConfig('momo_active', $request->has('momo_active') ? 1 : 0);
        $this->setConfig('momo_partner_code', $request->momo_partner_code);
        $this->setConfig('momo_access_key', $request->momo_access_key);
        $this->setConfig('momo_secret_key', $request->momo_secret_key);

        // Chuyển khoản ngân hàng
        $this->setConfig('bank_transfer_active', $request->has('bank_transfer_active') ? 1 : 0);
        $this->setConfig('bank_name', $request->bank_name);
        $this->setConfig('bank_account_number', $request->bank_account_number);
        $this->setConfig('bank_account_name', $request->bank_account_name);
        $this->setConfig('bank_branch', $request->bank_branch);

        // Xóa cache để cập nhật cài đặt
        $this->clearConfigCache();

        return redirect()->route('admin.settings.payment')
            ->with('success', 'Cài đặt thanh toán đã được cập nhật thành công.');
    }

    /**
     * Lấy giá trị cấu hình theo khóa
     */
    protected function getConfig($key, $default = null)
    {
        $cacheKey = 'config_' . $key;

        // Kiểm tra cache trước
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // Nếu không có trong cache, lấy từ database
        $config = Config::where('key', $key)->first();
        $value = $config ? $config->value : $default;

        // Lưu vào cache để sử dụng sau
        Cache::put($cacheKey, $value, now()->addDay());

        return $value;
    }

    /**
     * Cập nhật hoặc tạo mới cấu hình
     */
    protected function setConfig($key, $value)
    {
        Config::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        // Cập nhật cache
        Cache::put('config_' . $key, $value, now()->addDay());
    }

    /**
     * Xóa cache cấu hình
     */
    protected function clearConfigCache()
    {
        Cache::flush();
    }
}
