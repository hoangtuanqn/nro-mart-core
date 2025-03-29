<?php
/**
 * Copyright (c) 2025 FPT University
 * 
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GameAccount;
use App\Models\GameService;
use App\Models\ServiceHistory;
use Illuminate\Http\Request;

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
        return view('user.home', compact('categories', 'services'));
    }
}
