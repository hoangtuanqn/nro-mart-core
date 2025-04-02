<?php
namespace App\Providers;

use App\Models\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use App\Models\ServiceSetting;

class ServiceConfigProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadServiceSettings();
    }

    protected function loadServiceSettings()
    {
        // Load service settings from the configuration
        if (!empty(config('service.settings'))) {
            // Sử dụng cache để tránh truy vấn DB nhiều lần
            $settings = Cache::remember('service_settings', 3600, function () {
                return Config::all()->groupBy('provider')->map(function ($items) {
                    return $items->pluck('value', 'key')->all();
                })->all();
            });

            // Cập nhật cấu hình cho Google
            if (isset($settings['login_social.google.active'])) {
                config([
                    'services.google' => [
                        'client_id' => $settings['login_social.google.client_id'] ?? '',
                        'client_secret' => $settings['login_social.google.client_secret'] ?? '',
                        'redirect' => $settings['login_social.google.redirect'] ?? '',
                    ]
                ]);
            }

            // Cập nhật cấu hình cho Facebook
            if (isset($settings['login_social.facebook.active'])) {
                config([
                    'services.facebook' => [
                        'client_id' => $settings['login_social.facebook.client_id'] ?? '',
                        'client_secret' => $settings['login_social.facebook.client_secret'] ?? '',
                        'redirect' => $settings['login_social.facebook.redirect'] ?? '',
                    ]
                ]);
            }
        }

    }
}