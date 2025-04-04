<?php
use App\Models\Config;
use Illuminate\Support\Facades\Cache;

function display_status($status)
{
    $statusClasses = [
        'success' => 'success',
        'error' => 'error',
        'processing' => 'processing',
    ];

    $statusText = [
        'success' => 'Thành công',
        'error' => 'Thất bại',
        'processing' => 'Đang xử lý',
    ];

    $class = $statusClasses[$status] ?? 'unknown';
    $text = $statusText[$status] ?? 'Không xác định';

    return "<span class=\"status-badge {$class}\">{$text}</span>";
}

function display_status_service($status)
{
    $statusClasses = [
        'pending' => 'warning',
        'processing' => 'info',
        'completed' => 'success',
        'cancelled' => 'error',
    ];

    $statusText = [
        'pending' => 'Chờ xử lý',
        'processing' => 'Đang xử lý',
        'completed' => 'Hoàn thành',
        'cancelled' => 'Đã hủy',
    ];

    $class = $statusClasses[$status] ?? 'secondary';
    $text = $statusText[$status] ?? 'Không xác định';

    return "<span class=\"status-badge {$class}\">{$text}</span>";
}
function display_status_admin($status)
{
    $statusClasses = [
        'processing' => 'bg-info',
        'success' => 'bg-success',
        'error' => 'bg-danger',
    ];

    $statusText = [
        'processing' => 'Chờ xử lý',
        'success' => 'Hoàn thành',
        'error' => 'Đã hủy',
    ];

    $class = $statusClasses[$status] ?? 'secondary';
    $text = $statusText[$status] ?? 'Không xác định';

    return "<span class=\"badges {$class}\">{$text}</span>";
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
    return match ($planet) {
        'real' => 'Thật',
        'virtual' => 'Ảo',
        default => 'Không xác định',
    };
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

function get_id_bank($prefix, $comment)
{
    // Tìm vị trí của prefix trong comment (không phân biệt chữ hoa thường)
    $pos = stripos($comment, $prefix);
    if ($pos === false) {
        // Nếu không tìm thấy prefix, trả về 0 (hoặc có thể trả về null tùy theo logic)
        return 0;
    }
    // Lấy phần chuỗi sau prefix
    $substr = substr($comment, $pos + strlen($prefix));
    // Tìm số nguyên đầu tiên xuất hiện sau prefix
    if (preg_match('/\d+/', $substr, $matches)) {
        return (int) $matches[0];
    }

    return 0;
}


function display_status_transactions_admin($status)
{
    $statusClasses = [
        'deposit' => 'bg-lightgreen',
        'withdraw' => 'bg-lightred',
        'purchase' => 'bg-lightyellow',
        'refund' => 'bg-lightpurple',
    ];

    $statusText = [
        'deposit' => 'Nạp tiền',
        'withdraw' => 'Rút tiền',
        'purchase' => 'Mua hàng',
        'refund' => 'Hoàn tiền',
    ];

    $class = $statusClasses[$status] ?? 'bg-secondary';
    $text = $statusText[$status] ?? 'Khác';

    return "<span class=\"badges {$class}\">{$text}</span>";
}