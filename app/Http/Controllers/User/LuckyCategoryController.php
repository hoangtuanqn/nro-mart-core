<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LuckyWheel;
use Illuminate\Http\Request;

class LuckyCategoryController extends Controller
{
    //
    public function showAll()
    {
        $title = 'Vòng quay may mắn';
        // Get all categories with additional statistics

        $categories = LuckyWheel::where('active', 1)->get();
        foreach ($categories as $category) {
            // Tính số lượng đã quay
            $category->soldCount = $category->histories->count();
        }

        return view('user.category.show-all', compact('categories', 'title'));
    }
    public function index()
    {
        // dd('cc');
        $history = [];
        return view('user.wheel.detail', compact('history'));
    }
}
