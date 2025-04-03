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
        Schema::create('lucky_wheel_histories', function (Blueprint $table) {
            $table->id(); // ID tự động tăng, khóa chính
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // ID người dùng - Khóa ngoại liên kết với bảng users, xóa cấp liên
            $table->foreignId('lucky_wheel_id')->constrained('lucky_wheels')->cascadeOnDelete(); // ID vòng quay - Khóa ngoại liên kết với bảng lucky_wheels, xóa cấp liên
            $table->integer('spin_count'); // Số lượt quay - Tổng số lần quay trong phiên này (VD: 5 lượt)
            $table->bigInteger('total_cost'); // Tổng tiền - Tổng chi phí cho các lượt quay (VD: 50000 VNĐ)
            $table->enum('reward_type', ['gold', 'gem']); // Kiểu giá trị - Loại phần thưởng trúng được (vàng hoặc ngọc)
            $table->integer('reward_amount'); // Số lượng trúng - Số lượng vàng/ngọc trúng được (VD: 500 vàng)
            $table->text('description')->nullable(); // Mô tả - Nội dung hiển thị khi trúng thưởng (VD: "Trúng 500 vàng")
            $table->timestamps(); // Thời gian tạo và cập nhật - Tự động thêm created_at và updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lucky_wheel_histories');
    }
};