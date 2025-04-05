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
use App\Models\LuckyWheel;
use App\Models\LuckyWheelHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LuckyWheelController extends Controller
{
    /**
     * Hiển thị danh sách vòng quay may mắn
     */
    public function index()
    {
        $title = 'Quản lý vòng quay may mắn';
        $luckyWheels = LuckyWheel::orderBy('id', 'desc')->get();

        return view('admin.lucky-wheels.index', compact('luckyWheels', 'title'));
    }

    /**
     * Hiển thị form tạo mới vòng quay may mắn
     */
    public function create()
    {
        $title = 'Thêm vòng quay may mắn';

        // Tạo sẵn mảng config với 8 phần tử mặc định
        $defaultConfig = [
            ['type' => 'gold', 'content' => 'Trúng 1 tỷ vàng', 'amount' => 1000000000, 'probability' => 10],
            ['type' => 'gold', 'content' => 'Trúng 50 triệu vàng', 'amount' => 50000000, 'probability' => 15],
            ['type' => 'gold', 'content' => 'Trúng 75 triệu vàng', 'amount' => 75000000, 'probability' => 15],
            ['type' => 'gold', 'content' => 'Trúng 100 triệu vàng', 'amount' => 100000000, 'probability' => 15],
            ['type' => 'gold', 'content' => 'Trúng 130 triệu vàng', 'amount' => 130000000, 'probability' => 15],
            ['type' => 'gold', 'content' => 'Trúng 200 triệu vàng', 'amount' => 200000000, 'probability' => 10],
            ['type' => 'gold', 'content' => 'Trúng 250 triệu vàng', 'amount' => 250000000, 'probability' => 10],
            ['type' => 'gold', 'content' => 'Trúng 500 triệu vàng', 'amount' => 500000000, 'probability' => 10],
        ];

        return view('admin.lucky-wheels.create', compact('title', 'defaultConfig'));
    }

    /**
     * Lưu vòng quay may mắn mới
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price_per_spin' => 'required|numeric|min:1000',
                'thumbnail' => 'required|image|max:2048',
                'wheel_image' => 'required|image|max:2048',
                'description' => 'nullable|string',
                'rules' => 'required|string',
                'active' => 'required|boolean',
                'config' => 'required|array|size:8',
                'config.*.type' => 'required|in:gold,gem',
                'config.*.content' => 'required|string|max:255',
                'config.*.amount' => 'required|numeric|min:0',
                'config.*.probability' => 'required|numeric|min:0|max:100',
            ]);

            $totalProbability = 0;
            foreach ($request->config as $item) {
                $totalProbability += $item['probability'];
            }

            if ($totalProbability != 100) {
                return back()->withInput()->withErrors(['config' => 'Tổng xác suất phải bằng 100%']);
            }

            // Xử lý upload ảnh đại diện
            $thumbnailPath = $request->file('thumbnail')->store('lucky-wheels/thumbnails', 'public');
            $wheelImagePath = $request->file('wheel_image')->store('lucky-wheels/wheel-images', 'public');

            DB::beginTransaction();

            $luckyWheel = new LuckyWheel();
            $luckyWheel->name = $request->name;
            $luckyWheel->slug = Str::slug($request->name);
            $luckyWheel->price_per_spin = $request->price_per_spin;
            $luckyWheel->thumbnail = asset('storage/' . $thumbnailPath);
            $luckyWheel->wheel_image = asset('storage/' . $wheelImagePath);
            $luckyWheel->description = $request->description;
            $luckyWheel->rules = $request->rules;
            $luckyWheel->active = $request->active;
            $luckyWheel->config = $request->config;
            $luckyWheel->save();

            DB::commit();

            return redirect()->route('admin.lucky-wheels.index')
                ->with('success', 'Tạo vòng quay may mắn thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()->withInput()->withErrors(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    /**
     * Hiển thị form chỉnh sửa vòng quay may mắn
     */
    public function edit(LuckyWheel $luckyWheel)
    {
        $title = 'Chỉnh sửa vòng quay may mắn';

        // Không cần json_decode vì config đã được cast sang array tự động bởi model
        $config = $luckyWheel->config;

        // Đảm bảo config luôn có 8 phần tử
        if (!is_array($config) || count($config) < 8) {
            // Nếu config không phải là array hoặc dưới 8 phần tử, khởi tạo mới
            $config = [];
            for ($i = 0; $i < 8; $i++) {
                $config[] = [
                    'type' => 'gold',
                    'content' => 'Trúng vàng',
                    'amount' => 0,
                    'probability' => 0
                ];
            }
        }

        return view('admin.lucky-wheels.edit', compact('luckyWheel', 'title', 'config'));
    }

    /**
     * Cập nhật vòng quay may mắn
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price_per_spin' => 'required|numeric|min:1000',
                'thumbnail' => 'nullable|image|max:2048',
                'wheel_image' => 'nullable|image|max:2048',
                'description' => 'nullable|string',
                'rules' => 'required|string',
                'active' => 'required|boolean',
                'config' => 'required|array|size:8',
                'config.*.type' => 'required|in:gold,gem',
                'config.*.content' => 'required|string|max:255',
                'config.*.amount' => 'required|numeric|min:0',
                'config.*.probability' => 'required|numeric|min:0|max:100',
                'current_thumbnail' => 'required|string',
                'current_wheel_image' => 'required|string',
            ]);

            $totalProbability = 0;
            foreach ($request->config as $item) {
                $totalProbability += $item['probability'];
            }

            if ($totalProbability != 100) {
                return back()->withInput()->withErrors(['config' => 'Tổng xác suất phải bằng 100%']);
            }

            DB::beginTransaction();

            $luckyWheel = LuckyWheel::findOrFail($id);
            $luckyWheel->name = $request->name;
            $luckyWheel->slug = Str::slug($request->name);
            $luckyWheel->price_per_spin = $request->price_per_spin;

            // Xử lý upload ảnh đại diện nếu có
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('lucky-wheels/thumbnails', 'public');
                $luckyWheel->thumbnail = asset('storage/' . $thumbnailPath);
            } else {
                $luckyWheel->thumbnail = $request->current_thumbnail;
            }

            // Xử lý upload ảnh vòng quay nếu có
            if ($request->hasFile('wheel_image')) {
                $wheelImagePath = $request->file('wheel_image')->store('lucky-wheels/wheel-images', 'public');
                $luckyWheel->wheel_image = asset('storage/' . $wheelImagePath);
            } else {
                $luckyWheel->wheel_image = $request->current_wheel_image;
            }

            $luckyWheel->description = $request->description;
            $luckyWheel->rules = $request->rules;
            $luckyWheel->active = $request->active;
            $luckyWheel->config = $request->config;
            $luckyWheel->save();

            DB::commit();

            return redirect()->route('admin.lucky-wheels.index')
                ->with('success', 'Cập nhật vòng quay may mắn thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()->withInput()->withErrors(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    /**
     * Xóa vòng quay may mắn
     */
    public function destroy(LuckyWheel $luckyWheel)
    {
        try {
            // Bắt đầu transaction
            DB::beginTransaction();

            // Xóa vòng quay
            $luckyWheel->delete();

            // Commit transaction
            DB::commit();

            return redirect()->route('admin.lucky-wheels.index')
                ->with('success', 'Xóa vòng quay may mắn thành công');

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            // Log error
            Log::error('Error deleting lucky wheel: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị lịch sử vòng quay
     */
    public function history()
    {
        $title = 'Lịch sử vòng quay may mắn';
        $history = LuckyWheelHistory::with(['user', 'luckyWheel'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.lucky-wheels.history', compact('history', 'title'));
    }
}