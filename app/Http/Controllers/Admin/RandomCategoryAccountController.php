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
use App\Helpers\UploadHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RandomCategoryAccountController extends Controller
{
    /**
     * Đường dẫn thư mục lưu ảnh
     */
    private const UPLOAD_DIR = 'random-accounts';

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
        try {
            $request->validate([
                'random_category_id' => 'required|exists:random_categories,id',
                'accounts' => 'required|string',
                'server' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'note' => 'nullable|string',
                'note_buyer' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $data = $request->all();
            $accounts = explode("\n", trim($data['accounts']));
            $createdAccounts = [];
            $thumbnailPath = null;

            // Xử lý upload ảnh
            if ($request->hasFile('thumbnail')) {
                try {
                    $file = $request->file('thumbnail');

                    // Kiểm tra kích thước file
                    if ($file->getSize() > 2048 * 1024) { // 2MB
                        throw new \Exception('Kích thước ảnh không được vượt quá 2MB');
                    }

                    // Upload file
                    $thumbnailPath = UploadHelper::upload($file, self::UPLOAD_DIR);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Lỗi khi upload ảnh: ' . $e->getMessage());
                }
            }

            // Tạo các tài khoản
            foreach ($accounts as $accountLine) {
                $accountLine = trim($accountLine);
                if (empty($accountLine))
                    continue;

                $parts = explode('|', $accountLine);
                if (count($parts) !== 2)
                    continue;

                $accountData = [
                    'random_category_id' => $data['random_category_id'],
                    'account_name' => trim($parts[0]),
                    'password' => trim($parts[1]),
                    'server' => $data['server'],
                    'price' => $data['price'],
                    'status' => 'available',
                    'note' => $data['note'],
                    'note_buyer' => $data['note_buyer'],
                    'thumbnail' => $thumbnailPath,
                ];

                $createdAccounts[] = RandomCategoryAccount::create($accountData);
            }

            if (empty($createdAccounts)) {
                // Nếu không có tài khoản nào được tạo, xóa ảnh đã upload
                if ($thumbnailPath) {
                    UploadHelper::deleteByUrl($thumbnailPath);
                }
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Không có tài khoản hợp lệ nào được tạo!');
            }

            DB::commit();

            return redirect()->route('admin.random-accounts.index')
                ->with('success', count($createdAccounts) . ' tài khoản random đã được thêm thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating random accounts: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit(RandomCategoryAccount $account)
    {
        $title = 'Chỉnh sửa tài khoản random';
        $categories = RandomCategory::where('active', true)->get();
        return view('admin.random-accounts.edit', compact('title', 'account', 'categories'));
    }

    public function update(Request $request, RandomCategoryAccount $account)
    {
        try {
            $request->validate([
                'random_category_id' => 'required|exists:random_categories,id',
                'account_name' => 'nullable|string|max:100',
                'password' => 'nullable|string|max:100',
                'price' => 'required|numeric|min:0',
                'server' => 'required|integer|min:1',
                'note' => 'nullable|string',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            ]);

            DB::beginTransaction();

            $data = $request->all();

            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($account->thumbnail) {
                    UploadHelper::deleteByUrl($account->thumbnail);
                }

                // Upload new thumbnail
                $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR);
            }

            $account->update($data);

            DB::commit();

            return redirect()->route('admin.random-accounts.index')
                ->with('success', 'Tài khoản random đã được cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating random account: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(RandomCategoryAccount $account)
    {
        // Only allow deleting accounts that haven't been sold
        if ($account->status === 'sold') {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa tài khoản đã bán!'
                ], 400);
            }
            return redirect()->route('admin.random-accounts.index')
                ->with('error', 'Không thể xóa tài khoản đã bán!');
        }

        try {
            DB::beginTransaction();

            // Delete thumbnail if exists
            if ($account->thumbnail) {
                UploadHelper::deleteByUrl($account->thumbnail);
            }

            $account->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tài khoản random đã được xóa thành công!'
                ]);
            }

            return redirect()->route('admin.random-accounts.index')
                ->with('success', 'Tài khoản random đã được xóa thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting random account: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa tài khoản random. Lỗi: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->route('admin.random-accounts.index')
                ->with('error', 'Không thể xóa tài khoản random. Lỗi: ' . $e->getMessage());
        }
    }
}
