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
use App\Models\RandomCategory;
use App\Models\RandomCategoryAccount;
use Illuminate\Http\Request;

class RandomCategoryController extends Controller
{
    public function index(string $slug)
    {
        $category = RandomCategory::where("slug", $slug)->firstOrFail();

        // Get all available accounts linked to this category
        $accounts = RandomCategoryAccount::where('random_category_id', $category->id)
            ->where('status', 'available')
            ->orderBy('id', 'DESC')
            ->paginate(12);
        $title = mb_strtoupper($category->name, 'UTF-8');
        return view('user.random.category', compact('category', 'accounts', 'title'));
    }

    public function showAll()
    {
        $categories = RandomCategory::where('active', true)->get();

        // Count total accounts and sold accounts for each category
        foreach ($categories as $category) {
            $category->soldCount = RandomCategoryAccount::where('random_category_id', $category->id)
                ->where('status', 'sold')
                ->count();
            $category->allAccount = RandomCategoryAccount::where('random_category_id', $category->id)->count();
        }

        return view('user.random.show-all', compact('categories'));
    }
}
