<?php
use App\Models\Config;
use Illuminate\Support\Facades\Cache;

function display_status_nap_tien($status)
{
    switch ($status) {
        case 'success':
            return '<span class="status-badge success">Thành công</span>';
        case 'error':
            return '<span class="status-badge error">Lỗi</span>';
        case 'processing':
            return '<span class="status-badge processing">Đang xử lý</span>';
        default:
            return '<span class="status-badge unknown">Không xác định</span>';
    }
}
function display_status_service($status)
{
    switch ($status) {
        case 'pending':
            return '<span class="status-badge warning">Chờ xử lý</span>';
        case 'processing':
            return '<span class="status-badge info">Đang xử lý</span>';
        case 'completed':
            return '<span class="status-badge success">Hoàn thành</span>';
        case 'cancelled':
            return '<span class="status-badge error">Đã hủy</span>';
        default:
            return '<span class="status-badge secondary">Không xác định</span>';
    }
}
function display_hanh_tinh($planet)
{
    switch ($planet) {
        case 'xayda':
            return 'Xayda';
        case 'earth':
            return 'Trái đất';
        case 'namek':
            return 'Namek';
        default:
            return 'Không xác định';
    }
}

function display_dang_ky($planet)
{
    switch ($planet) {
        case 'real':
            return 'Thật';
        case 'virtual':
            return 'Ảo';
        default:
            return 'Không xác định';
    }
}

if (!function_exists('config_get')) {
    /**
     * Lấy giá trị cấu hình theo khóa
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function config_get($key, $default = null)
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
}

if (!function_exists('config_set')) {
    /**
     * Cập nhật hoặc tạo mới cấu hình
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    function config_set($key, $value)
    {
        Config::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        // Cập nhật cache
        Cache::put('config_' . $key, $value, now()->addDay());
    }
}

if (!function_exists('config_all')) {
    /**
     * Lấy tất cả cấu hình
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function config_all()
    {
        return Config::all();
    }
}

if (!function_exists('config_get_group')) {
    /**
     * Lấy một nhóm cấu hình theo tiền tố
     *
     * @param string $prefix
     * @return array
     */
    function config_get_group($prefix)
    {
        // Thêm dấu chấm nếu không có
        if (!empty($prefix) && !str_ends_with($prefix, '.')) {
            $prefix .= '.';
        }

        $configs = Config::where('key', 'LIKE', $prefix . '%')->get();
        $result = [];

        foreach ($configs as $config) {
            $key = str_replace($prefix, '', $config->key);
            $result[$key] = $config->value;
        }

        return $result;
    }
}

if (!function_exists('config_clear_cache')) {
    /**
     * Xóa cache cấu hình
     *
     * @return void
     */
    function config_clear_cache()
    {
        Cache::flush();
    }
}
