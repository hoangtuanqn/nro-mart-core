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
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiscountCodeController extends Controller
{
    public function index()
    {
        $title = "Danh sách mã giảm giá";
        $discountCodes = DiscountCode::orderBy('id', 'DESC')->get();
        return view('admin.discount-codes.index', compact('title', 'discountCodes'));
    }

    public function create()
    {
        $title = "Thêm mã giảm giá mới";
        return view('admin.discount-codes.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:discount_codes,code',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'expires_at' => 'nullable|date|after:today',
        ]);

        $data = $request->all();
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }

        // Generate code if not provided
        if (empty($data['code'])) {
            $data['code'] = Str::upper(Str::random(8));
        }

        DiscountCode::create($data);

        return redirect()->route('admin.discount-codes.index')
            ->with('success', 'Mã giảm giá đã được tạo thành công!');
    }

    public function edit(DiscountCode $discountCode)
    {
        $title = 'Chỉnh sửa mã giảm giá';
        return view('admin.discount-codes.edit', compact('title', 'discountCode'));
    }

    public function update(Request $request, DiscountCode $discountCode)
    {
        $request->validate([
            'code' => 'required|string|unique:discount_codes,code,' . $discountCode->id,
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'expires_at' => 'nullable|date',
        ]);

        $data = $request->all();
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }

        $discountCode->update($data);

        return redirect()->route('admin.discount-codes.index')
            ->with('success', 'Mã giảm giá đã được cập nhật thành công!');
    }

    public function destroy(DiscountCode $discountCode)
    {
        $discountCode->delete();

        return redirect()->route('admin.discount-codes.index')
            ->with('success', 'Mã giảm giá đã được xóa thành công!');
    }
}
