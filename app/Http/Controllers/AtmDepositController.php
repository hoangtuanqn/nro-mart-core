<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AtmDepositController extends Controller
{
    //
    public function index()
    {
        return view('user.profile.deposit-atm');
    }
}
