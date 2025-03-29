<?php
/**
 * Copyright (c) 2025 FPT University
 * 
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Http\Controllers;

use App\Models\GameService;
use App\Models\ServiceHistory;
use App\Models\ServicePackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServiceOrderController extends Controller
{
    /**
     * Hiển thị form đặt dịch vụ
     */
    public function showOrderForm($slug)
    {
        $service = GameService::with('packages')->where('slug', $slug)->firstOrFail();
        return view('user.service.show', compact('service'));
    }

    /**
     * Xử lý thanh toán và đặt dịch vụ
     */
    public function processOrder(Request $request)
    {
        // Validate đầu vào
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:game_services,id',
            'package_id' => 'required|exists:service_packages,id',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'server' => 'required|integer',
            'giftcode' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Lấy thông tin gói dịch vụ
        $package = ServicePackage::findOrFail($request->input('package_id'));

        // Kiểm tra đủ tiền hay không
        $user = User::findOrFail(Auth::id());
        if ($user->balance < $package->price) {
            return redirect()->back()
                ->with('error', 'Số dư không đủ để thanh toán dịch vụ này. Vui lòng nạp thêm tiền.')
                ->withInput();
        }

        // Tạo lịch sử dịch vụ
        $orderData = [
            'user_id' => Auth::id(),
            'game_service_id' => $request->input('service_id'),
            'service_package_id' => $request->input('package_id'),
            'game_account' => $request->input('username'),
            'game_password' => $request->input('password'),
            'server' => (int) $request->input('server'),
            'amount' => 1,
            'price' => $package->price,
            'discount_code' => $request->input('giftcode'),
            'discount_amount' => 0, // Xử lý mã giảm giá nếu cần
            'status' => 'pending',
        ];

        $serviceHistory = ServiceHistory::create($orderData);

        // Trừ tiền từ tài khoản người dùng
        $user->balance -= $package->price;
        $user->save();

        // Ghi log giao dịch (có thể thêm sau)

        return redirect()->route('user.services.order.success', $serviceHistory->id)
            ->with('success', 'Đặt dịch vụ thành công. Chúng tôi sẽ xử lý trong thời gian sớm nhất.');
    }

    /**
     * Hiển thị trang thành công
     */
    public function orderSuccess($id)
    {
        $order = ServiceHistory::findOrFail($id);

        // Kiểm tra quyền truy cập
        if ($order->user_id != Auth::id()) {
            abort(403, 'Không có quyền truy cập');
        }

        return view('user.service.success', compact('order'));
    }

    /**
     * Hiển thị lịch sử dịch vụ
     */
    public function orderHistory()
    {
        $orders = ServiceHistory::where('user_id', Auth::id())
            ->with(['gameService', 'servicePackage'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.service.history', compact('orders'));
    }

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function orderDetail($id)
    {
        $order = ServiceHistory::with(['gameService', 'servicePackage'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.service.detail', compact('order'));
    }

    /**
     * Hủy đơn hàng
     */
    public function cancelOrder($id)
    {
        $order = ServiceHistory::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        // Cập nhật trạng thái
        $order->status = 'cancelled';
        $order->save();

        // Hoàn tiền cho user
        $user = User::findOrFail(Auth::id());
        $user->balance += $order->price;
        $user->save();

        // Ghi log hoàn tiền (có thể thêm sau)

        return redirect()->back()->with('success', 'Đã hủy đơn hàng thành công. Số tiền đã được hoàn lại vào tài khoản của bạn.');
    }
}
