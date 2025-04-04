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
        Schema::create('withdrawal_histories', function (Blueprint $table) {
            $table->id(); // ID tự động tăng, khóa chính
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // ID người dùng - Khóa ngoại liên kết với bảng users, xóa cấp liên
            $table->integer('amount'); // Số lượng rút - Số lượng vàng/ngọc người dùng rút (VD: 1000 vàng)
            $table->enum('type', ['gold', 'gem']); // Kiểu giá trị - Loại tài nguyên rút (vàng hoặc ngọc)
            $table->string('character_name'); // Tên nhân vật game - Tên nhân vật trong game nhận tài nguyên
            $table->integer('server'); // Máy chủ - Số hoặc mã máy chủ mà tài nguyên được rút về (VD: 1, 2, 3...)
            $table->string('user_note')->nullable(); // Ghi chú của người dùng - Nội dung ghi chú mà người dùng để lại khi yêu cầu rút
            $table->string('admin_note')->nullable(); // Ghi chú của admin - Nội dung ghi chú mà admin để lại khi xử lý yêu cầu rút
            $table->enum('status', ['success', 'error', 'processing'])->default('processing'); // Trạng thái rút
            $table->timestamps(); // Thời gian tạo và cập nhật - Tự động thêm created_at và updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawal_histories');
    }
};