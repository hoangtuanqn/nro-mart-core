<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Hiển thị trang yêu cầu đặt lại mật khẩu
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Xử lý gửi link đặt lại mật khẩu
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email',
            'email.email' => 'Địa chỉ email không hợp lệ',
            'email.exists' => 'Không tìm thấy tài khoản với địa chỉ email này',
        ]);

        try {
            DB::beginTransaction();

            // Gửi link đặt lại mật khẩu
            $status = Password::sendResetLink(
                $request->only('email')
            );

            DB::commit();

            if ($status === Password::RESET_LINK_SENT) {
                return back()->with('status', 'Đã gửi liên kết đặt lại mật khẩu đến email của bạn!');
            }

            return back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi gửi link đặt lại mật khẩu: ' . $e->getMessage());

            return back()->withInput($request->only('email'))
                ->with('error', 'Đã xảy ra lỗi khi gửi liên kết đặt lại mật khẩu. Vui lòng thử lại sau.');
        }
    }
}
