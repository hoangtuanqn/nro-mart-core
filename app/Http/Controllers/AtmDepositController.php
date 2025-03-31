<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\BankDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtmDepositController extends Controller
{
    //
    public function index()
    {
        $bankAccounts = BankAccount::where('is_active', true)->get();

        // Get user's bank deposit history
        $transactions = BankDeposit::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.deposit-atm', compact('bankAccounts', 'transactions'));
    }
}
