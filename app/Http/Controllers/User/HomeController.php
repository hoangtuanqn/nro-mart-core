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

use App\Models\Category;
use App\Models\GameAccount;
use App\Models\GameService;
use App\Models\LuckyWheel;
use App\Models\ServiceHistory;
use App\Models\RandomCategory;
use App\Models\RandomCategoryAccount;
use App\Models\MoneyTransaction;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index()
    {
        // Dang mục bán acc game
        $categories = Category::where('active', 1)->orderBy('updated_at', 'desc')->get();
        foreach ($categories as $category) {
            $category->soldCount = GameAccount::where('game_category_id', $category->id)
                ->where('status', 'sold')
                ->count();
            $category->allAccount = GameAccount::where('game_category_id', $category->id)->count();
        }

        // Dịch vụ cày thuê
        $services = GameService::where('active', '1')->orderBy('updated_at', 'desc')->get();
        foreach ($services as $service) {
            $service->orderCount = ServiceHistory::where('game_service_id', $service->id)->count();
        }

        // Random categories
        $randomCategories = RandomCategory::where('active', 1)->orderBy('updated_at', 'desc')->get();
        foreach ($randomCategories as $category) {
            $category->soldCount = RandomCategoryAccount::where('random_category_id', $category->id)
                ->where('status', 'sold')
                ->count();
            $category->allAccount = RandomCategoryAccount::where('random_category_id', $category->id)->count();
        }

        // Vòng quay may mắn
        $LuckWheel = LuckyWheel::where('active', 1)->orderBy('updated_at', 'desc')->get();
        foreach ($LuckWheel as $wheel) {
            $wheel->soldCount = $wheel->histories->count();
        }

        // Lấy 20 giao dịch gần đây
        $recentTransactions = MoneyTransaction::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Lấy top 3 người nạp tiền nhiều nhất trong tháng hiện tại
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $topDepositors = MoneyTransaction::select('user_id', DB::raw('SUM(amount) as total_amount'))
            ->where('type', 'deposit')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('user_id')
            ->orderBy('total_amount', 'desc')
            ->limit(3)
            ->get();

        // Lấy thông tin người dùng cho top depositors
        foreach ($topDepositors as $depositor) {
            $depositor->user = \App\Models\User::find($depositor->user_id);
        }

        $notifications = Notification::orderBy('created_at', 'desc')->get();

        return view('user.home', compact(
            'categories',
            'services',
            'randomCategories',
            'LuckWheel',
            'recentTransactions',
            'topDepositors',
            'notifications'
        ));
    }
}
