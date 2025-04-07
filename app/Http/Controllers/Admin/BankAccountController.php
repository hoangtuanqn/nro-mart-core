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
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Quản lý tài khoản ngân hàng';
        $bankAccounts = BankAccount::orderBy('id', 'desc')->get();

        return view('admin.bank-accounts.index', compact('title', 'bankAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm tài khoản ngân hàng';
        return view('admin.bank-accounts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50|unique:bank_accounts,account_number,NULL,id,bank_name,' . $request->bank_name,
            'branch' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'prefix' => 'required|string|max:50',
            'access_token' => 'nullable|string',
        ]);

        // Xử lý các trường boolean
        $validated['is_active'] = $request->has('is_active');
        $validated['auto_confirm'] = $request->has('auto_confirm');

        BankAccount::create($validated);

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', 'Tài khoản ngân hàng đã được thêm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankAccount $bankAccount)
    {
        $title = 'Chỉnh sửa tài khoản ngân hàng';
        return view('admin.bank-accounts.edit', compact('title', 'bankAccount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50|unique:bank_accounts,account_number,' . $bankAccount->id . ',id,bank_name,' . $request->bank_name,
            'branch' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'prefix' => 'required|string|max:50',
            'access_token' => 'nullable|string',
        ]);

        // Xử lý các trường boolean
        $validated['is_active'] = $request->has('is_active');
        $validated['auto_confirm'] = $request->has('auto_confirm');

        $bankAccount->update($validated);

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', 'Tài khoản ngân hàng đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankAccount $bankAccount)
    {
        try {
            $bankAccount->delete();

            if (request()->ajax()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Tài khoản ngân hàng đã được xóa thành công.'
                ]);
            }

            return redirect()->route('admin.bank-accounts.index')
                ->with('success', 'Tài khoản ngân hàng đã được xóa thành công.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không thể xóa tài khoản ngân hàng. Lỗi: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.bank-accounts.index')
                ->with('error', 'Không thể xóa tài khoản ngân hàng. Lỗi: ' . $e->getMessage());
        }
    }
}
