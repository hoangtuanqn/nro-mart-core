<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameAccountController extends Controller
{
    //
    public function index()
    {
        return view("user.account.detail");
    }
}
