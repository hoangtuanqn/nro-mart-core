<?php

namespace App\Http\Controllers;

use App\Models\GameAccount;
use App\Models\GameCategory;
use Illuminate\Http\Request;

class GameCategoryController extends Controller
{
    //
    public function index(string $slug)
    {
        $category = GameCategory::where("slug", $slug)->first();
        $accounts = GameAccount::where("game_category_id", $category->id)->get();
        return view('user.category.show', compact('accounts', 'category'));
    }
}
