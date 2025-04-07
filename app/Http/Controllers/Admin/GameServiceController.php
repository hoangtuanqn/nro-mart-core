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
use App\Models\GameService;
use App\Helpers\UploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameServiceController extends Controller
{
    /**
     * Đường dẫn thư mục lưu ảnh
     */
    private const UPLOAD_DIR = 'services';

    public function index()
    {
        $title = 'Danh sách dịch vụ game';
        $services = GameService::orderBy('id', 'DESC')->get();
        return view('admin.services.index', compact('title', 'services'));
    }

    public function create()
    {
        $title = 'Thêm dịch vụ game mới';
        return view('admin.services.create', compact('title'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'type' => 'required|in:gold,gem,leveling',
                'active' => 'required|boolean',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);

            DB::beginTransaction();

            $data = $request->except(['thumbnail']);
            $data['slug'] = Str::slug($request->name);

            // Store thumbnail
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR . '/thumbnails');
            }

            GameService::create($data);

            DB::commit();

            return redirect()->route('admin.services.index')
                ->with('success', 'Dịch vụ game đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating game service: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $title = 'Chỉnh sửa dịch vụ game';
        $service = GameService::with('packages')->findOrFail($id);
        return view('admin.services.edit', compact('title', 'service'));
    }

    public function update(Request $request, $id)
    {
        try {
            $service = GameService::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'type' => 'required|in:gold,gem,leveling',
                'active' => 'required|boolean',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            ]);

            DB::beginTransaction();

            $data = $request->except(['thumbnail']);
            $data['slug'] = Str::slug($request->name);

            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($service->thumbnail) {
                    UploadHelper::deleteByUrl($service->thumbnail);
                }

                // Store new thumbnail
                $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR . '/thumbnails');
            }

            $service->update($data);

            DB::commit();

            return redirect()->route('admin.services.index')
                ->with('success', 'Dịch vụ game đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating game service: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $service = GameService::findOrFail($id);

            // Check if service has packages
            if ($service->packages()->count() > 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa dịch vụ này vì có gói dịch vụ liên kết với nó'
                ]);
            }

            // Delete thumbnail if exists
            if ($service->thumbnail) {
                UploadHelper::deleteByUrl($service->thumbnail);
            }

            // Delete the service record
            $service->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Dịch vụ game đã được xóa thành công'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting game service: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa dịch vụ game: ' . $e->getMessage()
            ]);
        }
    }
}
