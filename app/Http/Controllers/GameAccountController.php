<?php

namespace App\Http\Controllers;

use App\Models\GameAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameAccountController extends Controller
{
    public function show($id)
    {
        $account = GameAccount::findOrFail($id);

        $planetNames = [
            'earth' => 'Trái Đất',
            'namek' => 'Namek',
            'xayda' => 'Xayda'
        ];

        $registrationTypes = [
            'virtual' => 'Ảo',
            'real' => 'Thật'
        ];

        // Convert JSON string to array or provide empty array if null
        $images = json_decode($account->images) ?? [];

        return view("user.account.detail", compact('account', 'planetNames', 'registrationTypes', 'images'));
    }

    public function purchase($id)
    {
        try {
            DB::beginTransaction();

            $account = GameAccount::where('id', $id)
                ->where('status', 'available')
                ->lockForUpdate()
                ->firstOrFail();

            $user = Auth::user();

            if ($user->balance < $account->price) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số dư không đủ để mua tài khoản này'
                ]);
            }

            // Update user balance
            $user->balance -= $account->price;
            $user->save();

            // Update account status
            $account->status = 'sold';
            $account->buyer_id = $user->id;
            // $account->purchased_at = now();
            $account->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mua tài khoản thành công',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi mua tài khoản'
            ]);
        }
    }
}
