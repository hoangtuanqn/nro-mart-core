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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GameServiceController extends Controller
{
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:gold,gem,leveling',
            'active' => 'required|boolean',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['thumbnail']);

        // Generate slug
        $data['slug'] = Str::slug($request->name);

        // Store thumbnail
        if ($request->hasFile('thumbnail')) {
            $thumbPath = $request->file('thumbnail')->store('services/thumbnails', 'public');
            $data['thumbnail'] = "/storage/" . $thumbPath;
        }

        GameService::create($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Dịch vụ game đã được tạo thành công.');
    }

    public function edit($id)
    {
        $title = 'Chỉnh sửa dịch vụ game';
        $service = GameService::with('packages')->findOrFail($id);
        return view('admin.services.edit', compact('title', 'service'));
    }

    public function update(Request $request, $id)
    {
        $service = GameService::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:gold,gem,leveling',
            'active' => 'required|boolean',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['thumbnail']);

        // Update slug
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($service->thumbnail && Storage::disk('public')->exists(str_replace('/storage/', '', $service->thumbnail))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $service->thumbnail));
            }

            // Store new thumbnail
            $thumbPath = $request->file('thumbnail')->store('services/thumbnails', 'public');
            $data['thumbnail'] = "/storage/" . $thumbPath;
        }

        $service->update($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Dịch vụ game đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        try {
            $service = GameService::findOrFail($id);

            // Check if service has packages
            if ($service->packages()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa dịch vụ này vì có gói dịch vụ liên kết với nó'
                ], 400);
            }

            // Delete thumbnail if exists
            if ($service->thumbnail && Storage::disk('public')->exists(str_replace('/storage/', '', $service->thumbnail))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $service->thumbnail));
            }

            // Delete the service record
            $service->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa dịch vụ game: ' . $e->getMessage()
            ], 500);
        }
    }
}
