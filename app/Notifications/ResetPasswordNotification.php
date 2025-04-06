<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Token đặt lại mật khẩu
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
        $this->configureMailSettings();
    }

    /**
     * Cấu hình động cho mail settings
     */
    protected function configureMailSettings(): void
    {
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
            Config::set('mail.default', $mailDriver);
            Config::set('mail.mailers.smtp.host', $mailHost);
            Config::set('mail.mailers.smtp.port', $mailPort);
            Config::set('mail.mailers.smtp.username', $mailUsername);
            Config::set('mail.mailers.smtp.password', $mailPassword);
            Config::set('mail.mailers.smtp.encryption', $mailEncryption);
            Config::set('mail.from.address', $mailFromAddress);
            Config::set('mail.from.name', $mailFromName);

            // Log cấu hình để debug
            Log::info('Password reset email config:', [
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'username' => config('mail.mailers.smtp.username') ? 'set' : 'not-set',
                'from_address' => config('mail.from.address'),
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi cấu hình email đặt lại mật khẩu: ' . $e->getMessage());
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $siteName = config_get('site_name', 'Shop Game Ngọc Rồng');

        return (new MailMessage)
            ->subject('Đặt lại mật khẩu - ' . $siteName)
            ->view('emails.reset-password', [
                'resetUrl' => $resetUrl,
                'notifiable' => $notifiable,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}