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
use App\Models\GameAccount;
use App\Models\GameCategory;
use App\Models\GameService;
use App\Models\MoneyTransaction;
use App\Models\ServicePackage;
use App\Models\User;
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
            // Statistics for system entities
            $statistics = [
                'accounts' => [
                    'total' => GameAccount::count(),
                    'available' => GameAccount::where('status', 'available')->count(),
                    'sold' => GameAccount::where('status', 'sold')->count(),
                ],
                'services' => [
                    'total' => GameService::count(),
                    'active' => GameService::where('active', 1)->count(),
                ],
                'packages' => [
                    'total' => ServicePackage::count(),
                    'active' => ServicePackage::where('active', 1)->count(),
                ],
                'categories' => [
                    'total' => GameCategory::count(),
                    'active' => GameCategory::where('active', 1)->count(),
                ],
                'users' => [
                    'total' => User::count(),
                    'admin' => User::where('role', 'admin')->count(),
                    'user' => User::where('role', 'user')->count(),
                ],
            ];

            // Get service distribution by type
            $servicesByType = GameService::select('type', DB::raw('count(*) as total'))
                ->groupBy('type')
                ->get();

            // Get recent transactions (last 15)
            $recentTransactions = MoneyTransaction::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(15)
                ->get();

            // Get transaction summary
            $transactionSummary = [
                'total_deposit' => MoneyTransaction::where('type', 'deposit')->sum('amount'),
                'total_withdraw' => MoneyTransaction::where('type', 'withdraw')->sum('amount'),
                'total_purchase' => MoneyTransaction::where('type', 'purchase')->sum('amount'),
                'total_refund' => MoneyTransaction::where('type', 'refund')->sum('amount'),
            ];

            return view('admin.dashboard', compact(
                'statistics',
                'servicesByType',
                'recentTransactions',
                'transactionSummary'
            ));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Dashboard error: ' . $e->getMessage());

            // Return a simplified view in case of error
            return view('admin.dashboard', [
                'error' => $e->getMessage(),
                'statistics' => [],
                'servicesByType' => [],
                'recentTransactions' => [],
                'transactionSummary' => []
            ]);
        }
    }
}
