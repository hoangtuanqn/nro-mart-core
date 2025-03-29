<?php
/**
 * Copyright (c) 2025 FPT University
 * 
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Http\Controllers;

use App\Models\CardDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CardDepositController extends Controller
{
    /**
     * Display the card deposit form.
     */
    public function showCardDepositForm()
    {
        // Get user's card deposit transactions if authenticated
        $transactions = [];
        if (Auth::check()) {
            $transactions = CardDeposit::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('user.profile.deposit-card', compact('transactions'));
    }

    /**
     * Process a card deposit request.
     */
    public function processCardDeposit(Request $request)
    {
        // Validate the request
        $request->validate([
            'telco' => 'required|string|in:VIETTEL,MOBIFONE,VINAPHONE,VIETNAMOBILE',
            'amount' => 'required|numeric|in:10000,20000,50000,100000,200000,500000',
            'serial' => 'required|string|min:5|max:20',
            'pin' => 'required|string|min:5|max:20'
        ]);

        if (CardDeposit::where('status', 'processing')->where('user_id', Auth::id())->count() >= 5) {
            return redirect()->route('profile.deposit.card')
                ->with('error', 'Bạn có quá nhiều thẻ đang chờ xử lý. Vui lòng đợi!')->withInput();
        }
        try {
            // Create a new card deposit record
            $deposit = new CardDeposit();
            $deposit->user_id = Auth::id();
            $deposit->telco = $request->telco;
            $deposit->amount = $request->amount;
            $deposit->received_amount = $request->amount; // No discount
            $deposit->serial = $request->serial;
            $deposit->pin = $request->pin;
            $deposit->status = 'processing'; // Initial status
            $deposit->save();

            return redirect()->route('profile.deposit.card')
                ->with('success', 'Thẻ của bạn đang được xử lý. Vui lòng đợi trong giây lát.');

        } catch (\Exception $e) {
            // Log::error('Card deposit error: ' . $e->getMessage());

            return redirect()->route('profile.deposit.card')
                ->with('error', 'Có lỗi xảy ra khi xử lý thẻ. Vui lòng thử lại sau.')->withInput();
        }
    }
}