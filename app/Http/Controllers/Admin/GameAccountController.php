<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameAccount;
use App\Models\GameCategory;
use Illuminate\Http\Request;

class GameAccountController extends Controller
{
    public function index()
    {
        $accounts = GameAccount::with(['category', 'buyer'])->get();
        return view('admin.accounts.index', compact('accounts'));
    }

    public function create()
    {
        $categories = GameCategory::where('active', true)->get();
        return view('admin.accounts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_category_id' => 'required|exists:game_categories,id',
            'account_name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'server' => 'required|integer|min:1|max:13',
            'registration_type' => 'required|in:virtual,real',
            'planet' => 'required|in:earth,namek,xayda',
            'earring' => 'boolean',
            'note' => 'nullable|string',
            'thumb' => 'required|string',
            'images' => 'nullable|string'
        ]);

        GameAccount::create($validated);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Tài khoản game đã được tạo thành công.');
    }

    public function edit(GameAccount $account)
    {
        $categories = GameCategory::where('active', true)->get();
        return view('admin.accounts.edit', compact('account', 'categories'));
    }

    public function update(Request $request, GameAccount $account)
    {
        $validated = $request->validate([
            'game_category_id' => 'required|exists:game_categories,id',
            'account_name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'server' => 'required|integer|min:1|max:13',
            'registration_type' => 'required|in:virtual,real',
            'planet' => 'required|in:earth,namek,xayda',
            'earring' => 'boolean',
            'note' => 'nullable|string',
            'thumb' => 'required|string',
            'images' => 'nullable|string'
        ]);

        $account->update($validated);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Tài khoản game đã được cập nhật thành công.');
    }

    public function destroy(GameAccount $account)
    {
        try {
            $account->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa tài khoản game'
            ]);
        }
    }
}
