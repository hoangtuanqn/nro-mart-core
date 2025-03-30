<?php

namespace App\Helpers;

use App\Models\Config;
use Illuminate\Support\Facades\Cache;

class ConfigHelper
{
    /**
     * Lấy giá trị cấu hình theo khóa
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
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
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
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
     *
     * @return void
     */
    public static function clearCache()
    {
        Cache::flush();
    }

    /**
     * Lấy tất cả cấu hình theo tiền tố khóa
     *
     * @param string $prefix
     * @return array
     */
    public static function getByPrefix($prefix)
    {
        $configs = Config::where('key', 'LIKE', $prefix . '%')->get();
        $result = [];

        foreach ($configs as $config) {
            $key = str_replace($prefix, '', $config->key);
            $result[$key] = $config->value;
        }

        return $result;
    }

    /**
     * Lấy tất cả cấu hình
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAll()
    {
        return Config::all();
    }
}
