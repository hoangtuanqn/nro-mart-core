<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameAccount;
use App\Models\MoneyTransaction;
use App\Models\RandomAccountPurchase;
use App\Models\ServiceHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ResetController extends Controller
{
    /**
     * Hiển thị trang reset dữ liệu
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.settings.reset');
    }

    /**
     * Xử lý reset dữ liệu
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Request $request)
    {
        $request->validate([
            'admin_password' => 'required',
            'confirm_reset' => 'required',
        ], [
            'admin_password.required' => 'Vui lòng nhập mật khẩu admin.',
            'confirm_reset.required' => 'Vui lòng xác nhận việc reset dữ liệu.',
        ]);

        // Kiểm tra mật khẩu admin
        $admin = Auth::user();
        if (!Hash::check($request->admin_password, $admin->password)) {
            return redirect()->back()->with('error', 'Mật khẩu admin không chính xác!');
        }

        try {
            // Lưu thông tin admin
            $adminId = $admin->id;
            $adminUsername = $admin->username;

            // Tắt kiểm tra khóa ngoại
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // Lấy danh sách tất cả các bảng từ CSDL
            $tables = DB::select('SHOW TABLES');
            $dbName = DB::getDatabaseName();
            $tableColumnName = "Tables_in_$dbName";

            // Danh sách các bảng không cần truncate
            $excludeTables = [
                'migrations',
                'personal_access_tokens',
                'configs',
            ];

            // Truncate tất cả các bảng (trừ các bảng đặc biệt)
            foreach ($tables as $table) {
                if (isset($table->$tableColumnName)) {
                    $tableName = $table->$tableColumnName;
                    if (!in_array($tableName, $excludeTables)) {
                        DB::table($tableName)->truncate();
                        Log::info("Đã truncate bảng: $tableName");
                    }
                }
            }

            // Bật lại kiểm tra khóa ngoại
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            // Ghi log
            Log::info("Hệ thống đã được reset bởi admin: $adminUsername (ID: $adminId)");

            // Tạo lại tài khoản admin
            User::updateOrCreate(
                ['id' => $adminId],
                [
                    'username' => $adminUsername,
                    'password' => $admin->password,
                    'email' => $admin->email,
                    'role' => 'admin',
                ]
            );

            // Chạy seeder để tạo dữ liệu mặc định
            Log::info("Bắt đầu chạy seeder để tạo dữ liệu mặc định");
            try {
                \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
                $output = \Illuminate\Support\Facades\Artisan::output();
                Log::info("Kết quả seed: " . $output);
            } catch (\Exception $seedEx) {
                Log::error("Lỗi khi chạy seeder: " . $seedEx->getMessage());
                // Thử phương pháp khác nếu phương pháp đầu tiên thất bại
                try {
                    $seedOutput = shell_exec('php ' . base_path('artisan') . ' db:seed --force');
                    Log::info("Kết quả seed (phương pháp 2): " . $seedOutput);
                } catch (\Exception $shellEx) {
                    Log::error("Lỗi khi chạy seeder (phương pháp 2): " . $shellEx->getMessage());
                }
            }

            return redirect()->route('admin.settings.reset')->with('success', 'Đã reset toàn bộ dữ liệu hệ thống và tạo lại dữ liệu mặc định thành công!');
        } catch (\Exception $e) {
            // Đảm bảo bật lại kiểm tra khóa ngoại ngay cả khi có lỗi
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            Log::error('Lỗi khi reset dữ liệu: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Có lỗi xảy ra khi reset dữ liệu: ' . $e->getMessage());
        }
    }
}
