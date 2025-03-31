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
use App\Models\ServiceHistory;
use App\Models\RandomCategory;
use App\Models\RandomCategoryAccount;

class HomeController extends Controller
{
    //
    public function index()
    {
        // Dang mục bán acc game
        $categories = Category::where('active', 1)->get();
        foreach ($categories as $category) {
            $category->soldCount = GameAccount::where('game_category_id', $category->id)
                ->where('status', 'sold')
                ->count();
            $category->allAccount = GameAccount::where('game_category_id', $category->id)->count();
        }

        // Dịch vụ cày thuê
        $services = GameService::where('active', '1')->get();
        foreach ($services as $service) {
            $service->orderCount = ServiceHistory::where('game_service_id', $service->id)->count();
        }

        // Random categories
        $randomCategories = RandomCategory::where('active', 1)->get();
        foreach ($randomCategories as $category) {
            $category->soldCount = RandomCategoryAccount::where('random_category_id', $category->id)
                ->where('status', 'sold')
                ->count();
            $category->allAccount = RandomCategoryAccount::where('random_category_id', $category->id)->count();
        }

        return view('user.home', compact('categories', 'services', 'randomCategories'));
    }
}
