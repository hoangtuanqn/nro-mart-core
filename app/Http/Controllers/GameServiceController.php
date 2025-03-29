<?php

namespace App\Http\Controllers;

use App\Models\GameService;
use Illuminate\Http\Request;

class GameServiceController extends Controller
{
    //
    public function show($slug)
    {
        $service = GameService::with('packages')->where('slug', $slug)->firstOrFail();
        return view('user.service.show', compact('service'));
    }
}
