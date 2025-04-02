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
use App\Models\GameService;
use Illuminate\Http\Request;

class GameServiceController extends Controller
{
    //
    public function show($slug)
    {
        $service = GameService::with('packages')->where('slug', $slug)->firstOrFail();
        $title = $service->name;
        return view('user.service.show', compact('service', 'title'));
    }
    public function showAll()
    {
        $title = 'Dịch vụ thuê';
        $services = GameService::where('active', 1)->with('packages')->get();
        return view('user.service.show-all', compact('services', 'title'));
    }
}
