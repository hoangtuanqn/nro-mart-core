<?php
/**
 * Copyright (c) 2025 FPT University
 * 
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameAccount;
use App\Models\GameCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameAccountController extends Controller
{
    public function index()
    {
        $title = 'Danh sách tài khoản game';
        $accounts = GameAccount::with(['category', 'buyer'])->get();
        return view('admin.accounts.index', compact('title', 'accounts'));
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
        $title = 'Chỉnh sửa tài khoản game';
        $categories = GameCategory::where('active', true)->get();
        return view('admin.accounts.edit', compact('title', 'account', 'categories'));
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
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except(['thumb', 'images']);

        if ($request->hasFile('thumb')) {
            // Delete old thumbnail
            if ($account->thumb && Storage::disk('public')->exists($account->thumb)) {
                Storage::disk('public')->delete($account->thumb);
            }

            // Store new thumbnail
            $thumbPath = $request->file('thumb')->store('accounts/thumbnails', 'public');
            $data['thumb'] = "/storage/" . $thumbPath;
        }

        if ($request->hasFile('images')) {
            // Delete old images
            if ($account->images) {
                $oldImages = explode(',', $account->images);
                foreach ($oldImages as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }

            // Store new images
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('accounts/images', 'public');
            }
            $data['images'] = implode(',', $imagePaths);
        }

        $account->update($data);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Tài khoản game đã được cập nhật thành công.');
    }

    public function destroy(GameAccount $account)
    {
        try {
            // Delete thumbnail if exists
            if ($account->thumb && Storage::disk('public')->exists($account->thumb)) {
                Storage::disk('public')->delete($account->thumb);
            }

            // Delete additional images if exists
            if ($account->images) {
                $images = explode(',', $account->images);
                foreach ($images as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }

            // Delete the account record
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
