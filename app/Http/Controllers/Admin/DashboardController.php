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
use App\Models\BankDeposit;
use App\Models\CardDeposit;
use App\Models\Category;
use App\Models\DiscountCode;
use App\Models\GameAccount;
use App\Models\GameService;
use App\Models\LuckyWheel;
use App\Models\MoneyTransaction;
use App\Models\MoneyWithdrawalHistory;
use App\Models\Notification;
use App\Models\RandomCategory;
use App\Models\RandomCategoryAccount;
use App\Models\ServiceHistory;
use App\Models\ServicePackage;
use App\Models\User;
use App\Models\WithdrawalHistory;
use App\Models\AccountPurchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index(): View
    {
        try {
            // Lấy thông tin người dùng
            $statistics['users'] = [
                'total' => User::count(),
                'admin' => User::where('role', 'admin')->count(),
                'user' => User::where('role', 'user')->count(),
                'new_today' => User::whereDate('created_at', Carbon::today())->count(),
                'new_this_week' => User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
                'new_this_month' => User::whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)->count(),
            ];

            // Lấy thông tin tài khoản game
            $statistics['accounts'] = [
                'total' => GameAccount::count(),
                'available' => GameAccount::where('status', 'available')->count(),
                'sold' => GameAccount::where('status', 'sold')->count(),
                'locked' => GameAccount::where('status', 'locked')->count(),
                'pending' => GameAccount::where('status', 'pending')->count(),
            ];

            // Lấy thông tin tài khoản random
            $statistics['random_accounts'] = [
                'total' => RandomCategoryAccount::count(),
                'available' => RandomCategoryAccount::where('status', 'available')->count(),
                'sold' => RandomCategoryAccount::where('status', 'sold')->count(),
            ];

            // Lấy thông tin dịch vụ
            $statistics['services'] = [
                'total' => GameService::count(),
                'active' => GameService::where('active', true)->count(),
                'inactive' => GameService::where('active', false)->count(),
            ];

            // Lấy thông tin gói dịch vụ
            $statistics['packages'] = [
                'total' => ServicePackage::count(),
            ];

            // Lấy thông tin danh mục
            $statistics['categories'] = [
                'total' => Category::count(),
                'active' => Category::where('active', true)->count(),
                'inactive' => Category::where('active', false)->count(),
            ];

            // Lấy thông tin danh mục random
            $statistics['random_categories'] = [
                'total' => RandomCategory::count(),
                'active' => RandomCategory::where('active', true)->count(),
                'inactive' => RandomCategory::where('active', false)->count(),
            ];

            // Lấy thông tin vòng quay may mắn
            $statistics['lucky_wheels'] = [
                'total' => LuckyWheel::count(),
                'active' => LuckyWheel::where('active', true)->count(),
                'inactive' => LuckyWheel::where('active', false)->count(),
            ];

            // Lấy thông tin các loại dịch vụ
            $servicesByType = GameService::select('type', DB::raw('count(*) as total'))
                ->groupBy('type')
                ->get();

            // Lấy thông tin các giao dịch gần đây
            $recentTransactions = MoneyTransaction::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            // Tổng hợp các giao dịch theo loại
            $transactionSummary = [
                'total_deposit' => MoneyTransaction::where('type', 'deposit')->sum('amount'),
                'total_withdraw' => MoneyTransaction::where('type', 'withdraw')->sum('amount'),
                'total_purchase' => MoneyTransaction::where('type', 'purchase')->sum('amount'),
                'total_refund' => MoneyTransaction::where('type', 'refund')->sum('amount'),
            ];

            // Thống kê giao dịch trong 7 ngày gần nhất
            $last7Days = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $last7Days[] = [
                    'date' => $date->format('d/m'),
                    'deposits' => MoneyTransaction::whereDate('created_at', $date->format('Y-m-d'))
                        ->where('type', 'deposit')
                        ->sum('amount'),
                    'purchases' => MoneyTransaction::whereDate('created_at', $date->format('Y-m-d'))
                        ->where('type', 'purchase')
                        ->sum('amount'),
                ];
            }

            // Lấy thông tin các đơn dịch vụ chờ xử lý
            $pendingServices = ServiceHistory::with('user', 'gameService', 'servicePackage')
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Lấy thông tin rút tiền đang chờ xử lý
            $pendingWithdrawals = MoneyWithdrawalHistory::with('user')
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Lấy thông tin rút tài nguyên (gold/gem) đang chờ xử lý
            $pendingResourceWithdrawals = WithdrawalHistory::with('user')
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Lấy thông tin giao dịch nạp thẻ gần đây
            $recentCardDeposits = CardDeposit::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Lấy thông tin giao dịch nạp bank gần đây
            $recentBankDeposits = BankDeposit::with('user', 'bankAccount')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Lấy thông tin các mã giảm giá đang hoạt động
            $activeDiscountCodes = DiscountCode::where('is_active', 1)
                ->where(function ($query) {
                    $query->where('expire_date', '>=', Carbon::now())
                        ->orWhereNull('expire_date');
                })
                ->limit(5)
                ->get();

            // Lấy thống kê doanh thu theo tháng trong năm hiện tại
            $currentYear = Carbon::now()->year;
            $monthlyRevenue = [];
            for ($month = 1; $month <= 12; $month++) {
                $purchases = MoneyTransaction::where('type', 'purchase')
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->sum('amount');

                $deposits = MoneyTransaction::where('type', 'deposit')
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->sum('amount');

                $monthlyRevenue[] = [
                    'month' => Carbon::createFromDate($currentYear, $month, 1)->format('m/Y'),
                    'purchases' => $purchases,
                    'deposits' => $deposits,
                ];
            }

            // Lấy thông tin những tài khoản được mua gần đây
            $recentPurchases = GameAccount::with(['buyer', 'category'])
                ->where('status', 'sold')
                ->whereNotNull('buyer_id')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            // Lấy thông tin những tài khoản random được mua gần đây
            $recentRandomPurchases = RandomCategoryAccount::with(['buyer', 'randomCategory'])
                ->where('status', 'sold')
                ->whereNotNull('buyer_id')
                ->orderBy('created_at', 'desc')
                ->limit(2)
                ->get();

            // Kết hợp hai collection
            $recentPurchases = $recentPurchases->merge($recentRandomPurchases)->sortByDesc('created_at')->take(5);

            // Lấy danh sách thông báo để hiển thị trong modal
            $notifications = Notification::orderBy('created_at', 'desc')->get();

            return view('admin.dashboard', compact(
                'statistics',
                'servicesByType',
                'recentTransactions',
                'transactionSummary',
                'last7Days',
                'pendingServices',
                'pendingWithdrawals',
                'pendingResourceWithdrawals',
                'recentCardDeposits',
                'recentBankDeposits',
                'activeDiscountCodes',
                'monthlyRevenue',
                'recentPurchases',
                'notifications'
            ));
        } catch (\Exception $e) {
            // Ghi log lỗi
            Log::error('Dashboard error: ' . $e->getMessage());

            // Trả về view với thông báo lỗi và các biến trống để tránh lỗi undefined
            return view('admin.dashboard', [
                'error' => $e->getMessage(),
                'last7Days' => [],
                'statistics' => [],
                'servicesByType' => collect(),
                'recentTransactions' => collect(),
                'transactionSummary' => [],
                'pendingServices' => collect(),
                'pendingWithdrawals' => collect(),
                'pendingResourceWithdrawals' => collect(),
                'recentCardDeposits' => collect(),
                'recentBankDeposits' => collect(),
                'activeDiscountCodes' => collect(),
                'monthlyRevenue' => [],
                'recentPurchases' => collect(),
                'notifications' => collect()
            ]);
        }
    }
}
