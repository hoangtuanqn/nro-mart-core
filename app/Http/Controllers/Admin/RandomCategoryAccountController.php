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
use App\Models\RandomCategoryAccount;
use App\Models\RandomCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RandomCategoryAccountController extends Controller
{
    public function index()
    {
        $title = 'Danh sách tài khoản random';
        $accounts = RandomCategoryAccount::with(['category', 'buyer'])->orderBy('id', "DESC")->get();
        return view('admin.random-accounts.index', compact('title', 'accounts'));
    }

    public function create()
    {
        $title = 'Thêm tài khoản random mới';
        $categories = RandomCategory::where('active', true)->get();
        return view('admin.random-accounts.create', compact('title', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'random_category_id' => 'required|exists:random_categories,id',
            'account_name' => 'nullable|string|max:100',
            'password' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'server' => 'required|integer|min:1',
            'note' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/random-accounts', $filename);
            $data['thumbnail'] = Storage::url($path);
        }

        RandomCategoryAccount::create($data);

        return redirect()->route('admin.random-accounts.index')
            ->with('success', 'Tài khoản random đã được thêm thành công!');
    }

    public function edit(RandomCategoryAccount $account)
    {
        $title = 'Chỉnh sửa tài khoản random';
        $categories = RandomCategory::where('active', true)->get();
        return view('admin.random-accounts.edit', compact('title', 'account', 'categories'));
    }

    public function update(Request $request, RandomCategoryAccount $account)
    {
        $request->validate([
            'random_category_id' => 'required|exists:random_categories,id',
            'account_name' => 'nullable|string|max:100',
            'password' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'server' => 'required|integer|min:1',
            'note' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($account->thumbnail) {
                $oldPath = str_replace('/storage', 'public', $account->thumbnail);
                Storage::delete($oldPath);
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/random-accounts', $filename);
            $data['thumbnail'] = Storage::url($path);
        }

        $account->update($data);

        return redirect()->route('admin.random-accounts.index')
            ->with('success', 'Tài khoản random đã được cập nhật thành công!');
    }

    public function destroy(RandomCategoryAccount $account)
    {
        // Only allow deleting accounts that haven't been sold
        if ($account->status === 'sold') {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa tài khoản đã bán!'
                ], 400); // Bad request status
            }
            return redirect()->route('admin.random-accounts.index')
                ->with('error', 'Không thể xóa tài khoản đã bán!');
        }

        try {
            // Delete thumbnail if exists
            if ($account->thumbnail) {
                $path = str_replace('/storage', 'public', $account->thumbnail);
                Storage::delete($path);
            }

            $account->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tài khoản random đã được xóa thành công!'
                ]);
            }

            return redirect()->route('admin.random-accounts.index')
                ->with('success', 'Tài khoản random đã được xóa thành công!');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa tài khoản random. Lỗi: ' . $e->getMessage()
                ], 500); // Internal server error
            }
            return redirect()->route('admin.random-accounts.index')
                ->with('error', 'Không thể xóa tài khoản random. Lỗi: ' . $e->getMessage());
        }
    }
}
