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
use App\Models\GameCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GameCategoryController extends Controller
{
    public function index()
    {
        $title = "Danh sách danh mục game";
        $categories = GameCategory::orderBy('id', 'DESC')->get();
        return view('admin.categories.index', compact('title', 'categories'));
    }

    public function create()
    {
        $title = "Thêm danh mục game mới";
        return view('admin.categories.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:game_categories,name',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/categories', $filename);
            $data['thumbnail'] = Storage::url($path);
        }

        GameCategory::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục game đã được thêm thành công!');
    }

    public function edit(GameCategory $category)
    {
        $title = 'Chỉnh sửa danh mục game';
        return view('admin.categories.edit', compact('title', 'category'));
    }

    public function update(Request $request, GameCategory $category)
    {
        try {
            // Validate request data
            $request->validate([
                'name' => 'required|string|unique:game_categories,name,' . $category->id,
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
                'active' => 'boolean'
            ]);

            $data = $request->all();
            $data['slug'] = Str::slug($request->name);
            $oldThumbnail = null;

            if ($request->hasFile('thumbnail')) {
                try {
                    // Lưu đường dẫn ảnh cũ để xóa sau khi update thành công
                    if ($category->thumbnail) {
                        $oldThumbnail = str_replace('/storage', 'public', $category->thumbnail);
                    }

                    // Upload ảnh mới
                    $file = $request->file('thumbnail');
                    $filename = time() . '_' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('public/categories', $filename);
                    if (!$path) {
                        throw new \Exception('Không thể tải lên ảnh mới');
                    }
                    $data['thumbnail'] = Storage::url($path);
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['thumbnail' => 'Lỗi khi tải lên ảnh: ' . $e->getMessage()]);
                }
            }

            // Cập nhật dữ liệu
            // dd($data['description']);
            if (!$category->update($data)) {
                throw new \Exception('Không thể cập nhật danh mục');
            }

            // Xóa ảnh cũ sau khi cập nhật thành công
            if ($oldThumbnail) {
                try {
                    Storage::delete($oldThumbnail);
                } catch (\Exception $e) {
                    // Log lỗi nhưng không ảnh hưởng đến kết quả cập nhật
                    \Log::error('Lỗi xóa ảnh cũ: ' . $e->getMessage());
                }
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Cập nhật danh mục thành công!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    public function destroy(GameCategory $category)
    {
        try {
            if ($category->thumbnail) {
                Storage::delete(str_replace('/storage', 'public', $category->thumbnail));
            }

            $category->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa danh mục thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa danh mục: ' . $e->getMessage()
            ], 500);
        }
    }
}
