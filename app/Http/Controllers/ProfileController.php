<?php
/**
 * Copyright (c) 2025 FPT University
 * 
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\GameAccount;
use App\Models\MoneyTransaction;
use App\Models\ServiceHistory;  // Fix the import here
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index(Request $request): View
    {
        return view('user.profile.profile', [
            'user' => $request->user(),
        ]);
    }
    public function viewChangePassword()
    {
        return view('user.profile.change-password');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function transactionHistory()
    {
        $transactions = MoneyTransaction::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('user.profile.transaction-history', compact('transactions'));
    }

    public function purchasedAccounts()
    {
        $transactions = GameAccount::where('buyer_id', Auth::id())->where('status', 'sold')->get();
        return view('user.profile.purchased-accounts', compact('transactions')); // Return the view for purchased accounts lis
    }

    public function servicesHistory()
    {
        $serviceHistories = ServiceHistory::with(['gameService', 'servicePackage'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.services-history', compact('serviceHistories'));
    }

    // Remove this duplicate use statement
    // use App\Models\ServiceHistory;  // Remove this line

    public function getServiceDetail($id)
    {
        try {
            $service = ServiceHistory::with(['gameService', 'servicePackage'])
                ->where('user_id', Auth::id())
                ->findOrFail($id);
    
            return response()->json([
                'status' => 'success',
                'id' => $service->id,
                'game_service' => [
                    'name' => $service->gameService->name
                ],
                'game_account' => $service->game_account,
                'server' => $service->server,
                'service_package' => [
                    'name' => $service->servicePackage->name
                ],
                'price' => $service->price,
                'status' => $service->status,
                'admin_note' => $service->admin_note ?? 'Không có ghi chú'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể tải thông tin dịch vụ'
            ], 500);
        }
    }
}