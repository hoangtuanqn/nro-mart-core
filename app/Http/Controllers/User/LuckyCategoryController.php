<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LuckyWheel;
use App\Models\LuckyWheelHistory;
use App\Models\User;
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

        return view('user.wheel.categories', compact('categories', 'title'));
    }

    // Hiển thị chi tiết vòng quay
    public function index($id)
    {
        $wheel = LuckyWheel::findOrFail($id);

        // Lấy lịch sử quay của người dùng hiện tại
        $history = [];

        if (Auth::check()) {
            $history = LuckyWheelHistory::where('user_id', Auth::id())
                ->where('lucky_wheel_id', $id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        return view('user.wheel.detail', compact('wheel', 'history'));
    }

    // Xử lý quay vòng quay
    public function spin(Request $request, $id)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'spin_count' => 'required|integer|min:1|max:10',
        ]);

        $user = Auth::user();
        $wheel = LuckyWheel::findOrFail($id);
        $spinCount = $request->input('spin_count');
        $totalCost = $wheel->price_per_spin * $spinCount;

        // Kiểm tra số dư
        if ($user->balance < $totalCost) {
            return response()->json([
                'success' => false,
                'message' => 'Số dư không đủ để quay. Vui lòng nạp thêm tiền.'
            ]);
        }

        // Xác định phần thưởng
        $config = $wheel->config;
        $rewards = $config['rewards'] ?? [];

        // Danh sách phần thưởng nhận được
        $earnedRewards = [];

        // Xử lý quay và xác định phần thưởng
        for ($i = 0; $i < $spinCount; $i++) {
            // Tính toán phần thưởng dựa trên tỷ lệ
            $rewardIndex = $this->calculateReward($rewards);
            $reward = $rewards[$rewardIndex];

            $earnedRewards[] = $reward;

            // Lưu lịch sử
            LuckyWheelHistory::create([
                'user_id' => $user->id,
                'lucky_wheel_id' => $wheel->id,
                'spin_count' => 1,
                'total_cost' => $wheel->price_per_spin,
                'reward_type' => $reward['type'],
                'reward_amount' => $reward['value'],
                'description' => $reward['label'],
            ]);

            // Cộng thưởng vào tài khoản nếu là tiền
            if ($reward['type'] === 'money') {
                $user->balance += $reward['value'];
            }
        }

        // Trừ tiền từ tài khoản
        $user->balance -= $totalCost;
        $user->save();

        return response()->json([
            'success' => true,
            'rewards' => $earnedRewards,
            'new_balance' => $user->balance
        ]);
    }

    // Tính toán phần thưởng dựa trên tỷ lệ
    private function calculateReward($rewards)
    {
        $totalProbability = 0;
        foreach ($rewards as $reward) {
            $totalProbability += $reward['probability'];
        }

        $random = mt_rand(1, $totalProbability);
        $currentSum = 0;

        foreach ($rewards as $index => $reward) {
            $currentSum += $reward['probability'];
            if ($random <= $currentSum) {
                return $index;
            }
        }

        // Mặc định trả về phần thưởng đầu tiên nếu có lỗi
        return 0;
    }
}
