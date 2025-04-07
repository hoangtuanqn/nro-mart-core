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
use App\Helpers\UploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RandomCategoryController extends Controller
{
    /**
     * Đường dẫn thư mục lưu ảnh thumbnail
     */
    private const UPLOAD_DIR = 'random-categories';

    /**
     * Hiển thị danh sách danh mục random
     */
    public function index()
    {
        $title = "Danh sách danh mục random";
        $categories = RandomCategory::orderBy('id', 'DESC')->get();
        return view('admin.random-categories.index', compact('title', 'categories'));
    }

    /**
     * Hiển thị form tạo danh mục random mới
     */
    public function create()
    {
        $title = "Thêm danh mục random mới";
        return view('admin.random-categories.create', compact('title'));
    }

    /**
     * Lưu danh mục random mới vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:random_categories,name',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable|string',
            'active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['slug'] = Str::slug($request->name);

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR);
            }

            RandomCategory::create($data);

            DB::commit();

            return redirect()->route('admin.random-categories.index')
                ->with('success', 'Danh mục random đã được thêm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating random category: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Đã xảy ra lỗi khi thêm danh mục: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị form chỉnh sửa danh mục random
     */
    public function edit(RandomCategory $category)
    {
        $title = 'Chỉnh sửa danh mục random';
        return view('admin.random-categories.edit', compact('title', 'category'));
    }

    /**
     * Cập nhật danh mục random
     */
    public function update(Request $request, RandomCategory $category)
    {
        $request->validate([
            'name' => 'required|string|unique:random_categories,name,' . $category->id,
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable|string',
            'active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            if (!isset($data['active'])) {
                $data['active'] = false;
            }
            $data['slug'] = Str::slug($request->name);

            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($category->thumbnail) {
                    UploadHelper::deleteByUrl($category->thumbnail);
                }

                $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR);
            }

            $category->update($data);

            DB::commit();

            return redirect()->route('admin.random-categories.index')
                ->with('success', 'Danh mục random đã được cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating random category: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật danh mục: ' . $e->getMessage());
        }
    }

    /**
     * Xóa danh mục random
     */
    public function destroy(RandomCategory $category)
    {
        try {
            DB::beginTransaction();

            // Kiểm tra xem có tài khoản nào thuộc danh mục này không
            if ($category->accounts()->count() > 0) {
                DB::rollBack();

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
                UploadHelper::deleteByUrl($category->thumbnail);
            }

            $category->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Danh mục random đã được xóa thành công!'
                ]);
            }

            return redirect()->route('admin.random-categories.index')
                ->with('success', 'Danh mục random đã được xóa thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting random category: ' . $e->getMessage());

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
