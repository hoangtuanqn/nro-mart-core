<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameServiceController extends Controller
{
    //
    public function index()
    {
        return view('admin.services.index');
    }
}
