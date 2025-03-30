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
use App\Models\ServicePackage;
use Illuminate\Http\Request;

class ServicePackageController extends Controller
{
    public function index($serviceId = null)
    {
        $title = 'Danh sách gói dịch vụ';

        $packages = ServicePackage::with('service');

        if ($serviceId) {
            $service = GameService::findOrFail($serviceId);
            $packages = $packages->where('game_service_id', $serviceId);
            $title .= ' - ' . $service->name;
        }

        $packages = $packages->orderBy('id', 'DESC')->get();

        return view('admin.packages.index', compact('title', 'packages', 'serviceId'));
    }

    public function create($serviceId = null)
    {
        $title = 'Thêm gói dịch vụ mới';
        $services = GameService::where('active', 1)->get();
        $selectedService = null;

        if ($serviceId) {
            $selectedService = GameService::findOrFail($serviceId);
        }

        return view('admin.packages.create', compact('title', 'services', 'selectedService'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_service_id' => 'required|exists:game_services,id',
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'estimated_time' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'active' => 'required|boolean',
        ]);

        ServicePackage::create($request->all());

        return redirect()
            ->route('admin.packages.index', ['service_id' => $request->game_service_id])
            ->with('success', 'Gói dịch vụ đã được tạo thành công.');
    }

    public function edit($id)
    {
        $title = 'Chỉnh sửa gói dịch vụ';
        $package = ServicePackage::findOrFail($id);
        $services = GameService::where('active', 1)->get();

        return view('admin.packages.edit', compact('title', 'package', 'services'));
    }

    public function update(Request $request, $id)
    {
        $package = ServicePackage::findOrFail($id);

        $request->validate([
            'game_service_id' => 'required|exists:game_services,id',
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'estimated_time' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'active' => 'required|boolean',
        ]);

        $package->update($request->all());

        return redirect()
            ->route('admin.packages.index', ['service_id' => $request->game_service_id])
            ->with('success', 'Gói dịch vụ đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        try {
            $package = ServicePackage::findOrFail($id);
            $serviceId = $package->game_service_id;

            // Delete the package
            $package->delete();

            return response()->json(['success' => true, 'service_id' => $serviceId]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa gói dịch vụ: ' . $e->getMessage()
            ], 500);
        }
    }
}
