<?php

/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LuckyWheel;
use App\Models\LuckyWheelHistory;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LuckyCategoryController extends Controller
{
    // Hiển thị tất cả danh mục vòng quay
    public function showAll()
    {
        $title = 'Vòng Quay May Mắn';
        // Lấy tất cả danh mục vòng quay đang hoạt động
        $categories = LuckyWheel::where('active', 1)->get();

        foreach ($categories as $category) {
            // Tính số lượng đã quay
            $category->soldCount = $category->histories->count();
        }

        return view('user.wheel.show-all', compact('categories', 'title'));
    }

    // Hiển thị chi tiết vòng quay
    public function index($slug)
    {
        $wheel = LuckyWheel::where('slug', $slug)->where('active', 1)->firstOrFail();

        // Lấy lịch sử quay của người dùng hiện tại
        $history = [];

        if (Auth::check()) {
            $history = LuckyWheelHistory::with('user')->where('lucky_wheel_id', $wheel->id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        return view('user.wheel.detail', compact('wheel', 'history'));
    }

    // Xử lý quay vòng quay
    public function spin(Request $request, $slug)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để có thể quay'
            ]);
        }
        // Validate dữ liệu đầu vào
        try {
            $request->validate([
                'spin_count' => 'required|integer|min:1|max:10',
            ]);

            $user = Auth::user();
            $wheel = LuckyWheel::where('slug', $slug)->where('active', 1)->firstOrFail();
            $spinCount = $request->input('spin_count');
            $totalCost = $wheel->price_per_spin * $spinCount;

            // Kiểm tra số dư
            if ($user->balance < $totalCost) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số dư không đủ để quay. Vui lòng nạp thêm tiền.'
                ]);
            }

            // Lấy config từ wheel
            $config = $wheel->config;

            // Tính toán phần thưởng dựa trên tỷ lệ
            $rewardIndex = $this->calculateReward($config);
            $reward = $config[$rewardIndex];

            // Tạo kết quả phần thưởng
            $rewardResult = [
                'type' => $reward['type'],
                'content' => $reward['content'],
                'amount' => $reward['amount'] * $spinCount,
                'index' => $rewardIndex // Thêm index để frontend biết vị trí trúng
            ];

            // Lưu lịch sử với spin_count
            LuckyWheelHistory::create([
                'user_id' => $user->id,
                'lucky_wheel_id' => $wheel->id,
                'spin_count' => $spinCount,
                'total_cost' => $totalCost,
                'reward_type' => $reward['type'],
                'reward_amount' => $reward['amount'],
                'description' => $reward['content'],
            ]);

            // Cộng thưởng vào tài khoản
            if ($reward['type'] === 'gold') {
                $user->gold += $reward['amount'];
            } else if ($reward['type'] === 'gem') {
                $user->gem += $reward['amount'];
            }

            // Trừ tiền từ tài khoản
            $user->balance -= $totalCost;
            $user->save();

            return response()->json([
                'success' => true,
                'rewards' => [$rewardResult], // Vẫn giữ cấu trúc mảng để tương thích với frontend
                'new_balance' => $user->balance,
                'new_gold' => $user->gold,
                'new_gem' => $user->gem
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->errors() ? $e->errors()[0][0] : 'Validation error', // Lấy lỗi đầu tiên từ danh sách lỗi validation
            ]); // Mã trạng thái HTTP 422: Unprocessable Entity
        }
    }

    // Tính toán phần thưởng dựa trên tỷ lệ
    private function calculateReward($config)
    {
        $totalProbability = 0;
        foreach ($config as $reward) {
            $totalProbability += $reward['probability'];
        }

        $random = mt_rand(1, $totalProbability);
        $currentSum = 0;

        foreach ($config as $index => $reward) {
            $currentSum += $reward['probability'];
            if ($random <= $currentSum) {
                return $index;
            }
        }

        // Mặc định trả về phần thưởng đầu tiên nếu có lỗi
        return 0;
    }
}
