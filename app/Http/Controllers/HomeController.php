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
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $categories = Category::where('active', 1)->get();
        // Quan hệ 1 nhiều => Lấy ra số tài khoản đã bán
        $sold = 0;
        return view('user.home', compact('categories', 'sold'));
    }
}
