<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('money_withdrawal_histories', function (Blueprint $table) {
            $table->id(); // ID tự động tăng, khóa chính
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // ID người dùng - Khóa ngoại liên kết với bảng users, xóa cấp liên
            $table->bigInteger('amount'); // Số tiền rút - Số tiền người dùng yêu cầu rút (VD: 500000 VNĐ)
            $table->text('user_note')->nullable(); // Ghi chú cho admin - Ghi chú từ người dùng gửi đến admin (VD: "Rút tiền về tài khoản ngân hàng ABC")
            $table->text('admin_note')->nullable(); // Ghi chú từ admin - Ghi chú từ admin về trạng thái rút tiền (VD: "Đã chuyển khoản thành công")
            $table->enum('status', ['processing', 'success', 'error'])->default('processing'); // Trạng thái rút tiền - "processing": Đang xử lý, "success": Thành công, "error": Lỗi
            $table->timestamps(); // Thời gian tạo và cập nhật - Tự động thêm created_at và updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('money_withdrawal_histories');
    }
};