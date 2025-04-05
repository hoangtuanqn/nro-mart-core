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
use App\Http\Controllers\Admin\NotificationController;
use App\Mail\TestMail;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config as ConfigFacade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            'site_name' => config_get('site_name', 'Shop Game Ngọc Rồng - THIẾT KẾ BỞI TUANORI.VN'),
            'site_description' => config_get('site_description', 'Mua bán tài khoản game Ngọc Rồng'),
            'site_keywords' => config_get('site_keywords', 'Mua bán tài khoản game Ngọc Rồng'),
            'site_logo' => config_get('site_logo'),
            'site_logo_footer' => config_get('site_logo_footer'),
            'site_banner' => config_get('site_banner'),
            'site_favicon' => config_get('site_favicon'),
            'address' => config_get('address', ''),
            'phone' => config_get('phone', ''),
            'email' => config_get('email', ''),
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
            'site_keywords' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_logo_footer' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_favicon' => 'nullable|image|mimes:ico,png|max:1024',
        ]);

        try {
            DB::beginTransaction();

            // Xử lý upload logo nếu có
            if ($request->hasFile('site_logo')) {
                $logo = $request->file('site_logo');
                $logoName = 'logo.' . $logo->getClientOriginalExtension();
                $logo->move(public_path('assets/img'), $logoName);
                config_set('site_logo', asset('assets/img/' . $logoName));
            }

            // Xử lý upload logo footer nếu có
            if ($request->hasFile('site_logo_footer')) {
                $logoFooter = $request->file('site_logo_footer');
                $logoFooterName = 'logo_footer.' . $logoFooter->getClientOriginalExtension();
                $logoFooter->move(public_path('assets/img'), $logoFooterName);
                config_set('site_logo_footer', asset('assets/img/' . $logoFooterName));
            }

            // Xử lý upload banner nếu có
            if ($request->hasFile('site_banner')) {
                $banner = $request->file('site_banner');
                $bannerName = 'banner.' . $banner->getClientOriginalExtension();
                $banner->move(public_path('assets/img'), $bannerName);
                config_set('site_banner', asset('assets/img/' . $bannerName));
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
            config_set('site_keywords', $request->site_keywords);
            config_set('site_description', $request->site_description);
            config_set('address', $request->address);
            config_set('phone', $request->phone);
            config_set('email', $request->email);

            // Xóa cache để cập nhật cài đặt
            config_clear_cache();

            DB::commit();
            return redirect()->route('admin.settings.general')
                ->with('success', 'Cài đặt chung đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi cập nhật cài đặt chung: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật cài đặt: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hiển thị và cập nhật cài đặt mạng xã hội
     */
    public function social()
    {
        $title = 'Cài đặt mạng xã hội';

        // Lấy tất cả cấu hình mạng xã hội
        $configs = [
            'facebook' => config_get('facebook', ''),
            'zalo' => config_get('zalo', ''),
            'youtube' => config_get('youtube', ''),
            'discord' => config_get('discord', ''),
            'telegram' => config_get('telegram', ''),
            'tiktok' => config_get('tiktok', ''),
            'working_hours' => config_get('working_hours', '8:00 - 22:00'),
            'home_notification' => config_get('home_notification', ''),
            'welcome_modal' => config_get('welcome_modal', true),
        ];

        return view('admin.settings.social', compact('title', 'configs'));
    }

    /**
     * Cập nhật cài đặt mạng xã hội
     */
    public function updateSocial(Request $request)
    {
        $request->validate([
            'facebook' => 'nullable|string|max:255',
            'zalo' => 'nullable|string|max:20',
            'youtube' => 'nullable|string|max:255',
            'discord' => 'nullable|string|max:255',
            'telegram' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'working_hours' => 'nullable|string|max:100',
            'home_notification' => 'nullable|string',
            'welcome_modal' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            // Cập nhật các cài đặt mạng xã hội
            config_set('facebook', $request->facebook);
            config_set('zalo', $request->zalo);
            config_set('youtube', $request->youtube);
            config_set('discord', $request->discord);
            config_set('telegram', $request->telegram);
            config_set('tiktok', $request->tiktok);
            config_set('working_hours', $request->working_hours);
            config_set('home_notification', $request->home_notification);
            config_set('welcome_modal', $request->has('welcome_modal') ? true : false);

            // Xóa cache để cập nhật cài đặt
            config_clear_cache();

            DB::commit();
            return redirect()->route('admin.settings.social')
                ->with('success', 'Cài đặt mạng xã hội đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi cập nhật cài đặt mạng xã hội: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật cài đặt: ' . $e->getMessage())
                ->withInput();
        }
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

        try {
            DB::beginTransaction();

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

            DB::commit();
            return redirect()->route('admin.settings.email')
                ->with('success', 'Cài đặt email đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi cập nhật cài đặt email: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật cài đặt: ' . $e->getMessage())
                ->withInput();
        }
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
            'discount_percent_card' => config_get('payment.card.discount_percent', '0'),
            'partner_website_card' => config_get('payment.card.partner_website', 'thesieure.com'),

            // Thêm cấu hình ngân hàng/ví điện tử nếu cần
            'bank_active' => config_get('payment.bank.active', true),
            'momo_active' => config_get('payment.momo.active', true),
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
            'partner_website_card' => 'string|in:thesieure.com,cardvip.vn,doithe1s.vn',
            'partner_id_card' => 'nullable|string|max:100',
            'partner_key_card' => 'nullable|string|max:100',
            'discount_percent_card' => 'nullable|integer|between:0,99',
            'bank_active' => 'nullable|boolean',
            'momo_active' => 'nullable|boolean',
        ], [
            'partner_website_card.in' => 'Chọn đối tác chưa hợp lệ. Bạn muốn thêm đối tác hãy liên hệ chúng tôi.'
        ]);

        try {
            DB::beginTransaction();

            // Nạp thẻ cào
            config_set('payment.card.active', $request->has('card_active') ? 1 : 0);
            config_set('payment.card.partner_id', $request->partner_id_card);
            config_set('payment.card.partner_key', $request->partner_key_card);
            config_set('payment.card.discount_percent', $request->discount_percent_card);
            config_set('payment.card.partner_website', $request->partner_website_card);

            // Chuyển khoản ngân hàng
            config_set('payment.bank.active', $request->has('bank_active') ? 1 : 0);

            // Ví MoMo
            config_set('payment.momo.active', $request->has('momo_active') ? 1 : 0);

            // Xóa cache để cập nhật cài đặt
            config_clear_cache();

            DB::commit();
            return redirect()->route('admin.settings.payment')
                ->with('success', 'Cài đặt thanh toán đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi cập nhật cài đặt thanh toán: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật cài đặt: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hiển thị trang cấu hình đăng nhập mạng xã hội
     */
    public function login()
    {
        $title = 'Cấu hình đăng nhập';

        // Lấy các cấu hình đăng nhập
        $configs = [
            'google_client_id' => config_get('login_social.google.client_id', ''),
            'google_client_secret' => config_get('login_social.google.client_secret', ''),
            'google_redirect' => config_get('login_social.google.redirect', ''),
            'google_active' => config_get('login_social.google.active', '0'),
            'facebook_client_id' => config_get('login_social.facebook.client_id', ''),
            'facebook_client_secret' => config_get('login_social.facebook.client_secret', ''),
            'facebook_redirect' => config_get('login_social.facebook.redirect', ''),
            'facebook_active' => config_get('login_social.facebook.active', '0'),
        ];

        return view('admin.settings.login', compact('title', 'configs'));
    }

    /**
     * Cập nhật cấu hình đăng nhập mạng xã hội
     */
    public function updateLogin(Request $request)
    {
        $checkGoogle = 'nullable';
        $checkFacebook = 'nullable';

        if ($request->has('google_active')) {
            $checkGoogle = 'required';
        }

        if ($request->has('facebook_active')) {
            $checkFacebook = 'required';
        }

        $request->validate([
            'google_client_id' => $checkGoogle . '|string',
            'google_client_secret' => $checkGoogle . '|string',
            'google_redirect' => $checkGoogle . '|string',
            'google_active' => 'nullable|boolean',
            'facebook_client_id' => $checkFacebook . '|string',
            'facebook_client_secret' => $checkFacebook . '|string',
            'facebook_redirect' => $checkFacebook . '|string',
            'facebook_active' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            // Google Login
            config_set('login_social.google.client_id', $request->google_client_id);
            config_set('login_social.google.client_secret', $request->google_client_secret);
            config_set('login_social.google.redirect', $request->google_redirect);
            config_set('login_social.google.active', $request->has('google_active') ? '1' : '0');

            // Facebook Login
            config_set('login_social.facebook.client_id', $request->facebook_client_id);
            config_set('login_social.facebook.client_secret', $request->facebook_client_secret);
            config_set('login_social.facebook.redirect', $request->facebook_redirect);
            config_set('login_social.facebook.active', $request->has('facebook_active') ? '1' : '0');

            // Xóa cache để cập nhật cài đặt
            config_clear_cache();

            DB::commit();
            return redirect()->route('admin.settings.login')
                ->with('success', 'Cài đặt đăng nhập đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi cập nhật cài đặt đăng nhập: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật cài đặt: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Gửi email kiểm tra cấu hình
     */
    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        try {
            // Gửi email test
            $mailConfig = [
                'transport' => config_get('mail_mailer'),
                'host' => config_get('mail_host'),
                'port' => config_get('mail_port'),
                'username' => config_get('mail_username'),
                'password' => config_get('mail_password'),
                'encryption' => config_get('mail_encryption'),
                'from' => [
                    'address' => config_get('mail_from_address'),
                    'name' => config_get('mail_from_name'),
                ],
            ];

            ConfigFacade::set('mail', $mailConfig);

            Mail::to($request->test_email)->send(new TestMail());

            return redirect()->back()
                ->with('success', 'Email kiểm tra đã được gửi thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi gửi email test: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Không thể gửi email kiểm tra: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị trang quản lý thông báo
     */
    public function notifications()
    {
        $title = 'Quản lý thông báo';

        // Chuyển hướng đến controller NotificationController
        return app(NotificationController::class)->index();
    }
}
