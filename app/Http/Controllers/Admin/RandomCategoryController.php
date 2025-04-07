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
use App\Models\RandomCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RandomCategoryController extends Controller
{
    public function index()
    {
        $title = "Danh sách danh mục random";
        $categories = RandomCategory::orderBy('id', 'DESC')->get();
        return view('admin.random-categories.index', compact('title', 'categories'));
    }

    public function create()
    {
        $title = "Thêm danh mục random mới";
        return view('admin.random-categories.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:random_categories,name',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/random-categories', $filename);
            $data['thumbnail'] = Storage::url($path);
        }

        RandomCategory::create($data);

        return redirect()->route('admin.random-categories.index')
            ->with('success', 'Danh mục random đã được thêm thành công!');
    }

    public function edit(RandomCategory $category)
    {
        $title = 'Chỉnh sửa danh mục random';
        return view('admin.random-categories.edit', compact('title', 'category'));
    }

    public function update(Request $request, RandomCategory $category)
    {
        $request->validate([
            'name' => 'required|string|unique:random_categories,name,' . $category->id,
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $data = $request->all();
        if (!isset($data['active'])) {
            $data['active'] = false;
        }
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($category->thumbnail) {
                $oldPath = str_replace('/storage', 'public', $category->thumbnail);
                Storage::delete($oldPath);
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/random-categories', $filename);
            $data['thumbnail'] = Storage::url($path);
        }

        $category->update($data);

        return redirect()->route('admin.random-categories.index')
            ->with('success', 'Danh mục random đã được cập nhật thành công!');
    }

    public function destroy(RandomCategory $category)
    {
        try {
            // Kiểm tra xem có tài khoản nào thuộc danh mục này không
            if ($category->accounts()->count() > 0) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không thể xóa danh mục này vì có tài khoản thuộc danh mục!'
                    ], 400);
                }
                return redirect()->route('admin.random-categories.index')
                    ->with('error', 'Không thể xóa danh mục này vì có tài khoản thuộc danh mục!');
            }

            // Delete thumbnail if exists
            if ($category->thumbnail) {
                $path = str_replace('/storage', 'public', $category->thumbnail);
                Storage::delete($path);
            }

            $category->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Danh mục random đã được xóa thành công!'
                ]);
            }

            return redirect()->route('admin.random-categories.index')
                ->with('success', 'Danh mục random đã được xóa thành công!');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa danh mục random. Lỗi: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->route('admin.random-categories.index')
                ->with('error', 'Không thể xóa danh mục random. Lỗi: ' . $e->getMessage());
        }
    }
}
