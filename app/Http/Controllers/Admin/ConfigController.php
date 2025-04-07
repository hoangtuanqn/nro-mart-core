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

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Helpers\UploadHelper;

class ConfigController extends Controller
{
    /**
     * Đường dẫn thư mục lưu ảnh
     */
    private const UPLOAD_DIR = 'config';

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
            'site_share_image' => config_get('site_share_image'),
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
            'site_share_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_favicon' => 'nullable|image|mimes:ico,png|max:1024',
        ]);

        try {
            DB::beginTransaction();

            // Xử lý upload các file ảnh
            $fieldImages = [
                'logo',
                'logo_footer',
                'banner',
                'favicon',
                'share_image',
            ];

            foreach ($fieldImages as $key) {
                if ($request->hasFile('site_' . $key)) {
                    // Xóa file cũ nếu có
                    $oldImage = config_get('site_' . $key);
                    if ($oldImage) {
                        UploadHelper::deleteByUrl($oldImage);
                    }

                    // Upload file mới
                    $imageUrl = UploadHelper::upload($request->file('site_' . $key), self::UPLOAD_DIR);
                    config_set('site_' . $key, $imageUrl);
                }
            }

            // Cập nhật các cài đặt khác
            $listConfig = [
                'site_name',
                'site_keywords',
                'site_description',
                'address',
                'phone',
                'email'
            ];
            foreach ($listConfig as $key) {
                config_set($key, $request->$key);
            }

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
        // Base validation rules
        $rules = [
            'google_client_id' => 'nullable|string|max:255',
            'google_client_secret' => 'nullable|string|max:255',
            'google_redirect' => 'nullable|string|max:255',
            'facebook_client_id' => 'nullable|string|max:255',
            'facebook_client_secret' => 'nullable|string|max:255',
            'facebook_redirect' => 'nullable|string|max:255',
        ];

        // Additional validation when services are active
        if ($request->has('google_active')) {
            $rules['google_client_id'] = 'required|string|max:255';
            $rules['google_client_secret'] = 'required|string|max:255';
            $rules['google_redirect'] = 'required|string|max:255';
        }

        if ($request->has('facebook_active')) {
            $rules['facebook_client_id'] = 'required|string|max:255';
            $rules['facebook_client_secret'] = 'required|string|max:255';
            $rules['facebook_redirect'] = 'required|string|max:255';
        }

        $messages = [
            'required' => ':attribute không được để trống khi kích hoạt dịch vụ',
            'string' => ':attribute phải là chuỗi',
            'max' => ':attribute không được vượt quá :max ký tự',
            'url' => ':attribute phải là một URL hợp lệ',
        ];

        $attributes = [
            'google_client_id' => 'Google Client ID',
            'google_client_secret' => 'Google Client Secret',
            'google_redirect' => 'Google Redirect URL',
            'facebook_client_id' => 'Facebook App ID',
            'facebook_client_secret' => 'Facebook App Secret',
            'facebook_redirect' => 'Facebook Redirect URL',
        ];

        $request->validate($rules, $messages, $attributes);

        try {
            DB::beginTransaction();

            // Google Login
            config_set('login_social.google.client_id', $request->google_client_id ?: '');
            config_set('login_social.google.client_secret', $request->google_client_secret ?: '');
            config_set('login_social.google.redirect', $request->google_redirect ?: '');
            config_set('login_social.google.active', $request->has('google_active') ? '1' : '0');

            // Facebook Login
            config_set('login_social.facebook.client_id', $request->facebook_client_id ?: '');
            config_set('login_social.facebook.client_secret', $request->facebook_client_secret ?: '');
            config_set('login_social.facebook.redirect', $request->facebook_redirect ?: '');
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
            // Lấy cấu hình email từ database
            $mailDriver = config_get('mail_mailer');
            $mailHost = config_get('mail_host');
            $mailPort = config_get('mail_port');
            $mailUsername = config_get('mail_username');
            $mailPassword = config_get('mail_password');
            $mailEncryption = config_get('mail_encryption');
            $mailFromAddress = config_get('mail_from_address');
            $mailFromName = config_get('mail_from_name');

            // Kiểm tra và sử dụng giá trị mặc định nếu không có cấu hình
            if (empty($mailHost) || $mailHost === 'mailpit') {
                $mailHost = 'smtp.gmail.com'; // Hoặc SMTP server khác
            }

            if (empty($mailPort)) {
                $mailPort = 587; // Port tiêu chuẩn cho SMTP với TLS
            }

            if (empty($mailEncryption) || $mailEncryption === 'null') {
                $mailEncryption = 'tls';
            }

            if (empty($mailFromAddress) || $mailFromAddress === 'hello@example.com') {
                $mailFromAddress = config_get('email', 'admin@example.com');
            }

            if (empty($mailFromName)) {
                $mailFromName = config_get('site_name', 'Shop Game Ngọc Rồng');
            }

            // Thiết lập cấu hình mail động
            config([
                'mail.default' => $mailDriver,
                'mail.mailers.smtp.host' => $mailHost,
                'mail.mailers.smtp.port' => $mailPort,
                'mail.mailers.smtp.username' => $mailUsername,
                'mail.mailers.smtp.password' => $mailPassword,
                'mail.mailers.smtp.encryption' => $mailEncryption,
                'mail.from.address' => $mailFromAddress,
                'mail.from.name' => $mailFromName,
            ]);

            // Log cấu hình để debug
            Log::info('Test email config:', [
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'username' => config('mail.mailers.smtp.username') ? 'set' : 'not-set',
                'from_address' => config('mail.from.address'),
            ]);

            Mail::to($request->test_email)->send(new TestMail());

            return redirect()->back()
                ->with('success', 'Email kiểm tra đã được gửi thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi gửi email test: ' . $e->getMessage());

            // Kiểm tra lỗi kết nối host
            if (
                strpos($e->getMessage(), 'getaddrinfo') !== false ||
                strpos($e->getMessage(), 'Connection could not be established') !== false
            ) {
                return redirect()->back()
                    ->with('error', 'Không thể kết nối đến máy chủ email. Hãy kiểm tra lại cấu hình SMTP (host, port) hoặc kết nối internet.')
                    ->withInput();
            }

            // Kiểm tra lỗi xác thực
            if (
                strpos($e->getMessage(), 'Authentication failed') !== false ||
                strpos($e->getMessage(), '5.7.0 Authentication') !== false
            ) {
                return redirect()->back()
                    ->with('error', 'Xác thực SMTP thất bại. Hãy kiểm tra lại tên người dùng và mật khẩu SMTP.')
                    ->withInput();
            }

            return redirect()->back()
                ->with('error', 'Không thể gửi email kiểm tra: ' . $e->getMessage())
                ->withInput();
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
