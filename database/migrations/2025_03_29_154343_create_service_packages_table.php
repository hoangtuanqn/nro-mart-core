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
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id(); // ID tự động tăng
            $table->foreignId('game_service_id')->constrained('game_services')->cascadeOnDelete(); // Liên kết với bảng dịch vụ
            $table->string('name'); // Tên gói (VD: Gói 1000 vàng, Gói 50 ngọc...)
            $table->bigInteger('price'); // Giá bán
            $table->integer('estimated_time')->nullable(); // Thời gian ước tính (phút), dùng cho dịch vụ cày thuê
            $table->text('description')->nullable(); // Mô tả thêm
            $table->boolean('active')->default(true); // Trạng thái (1: hiển thị, 0: ẩn)
            $table->timestamps(); // Ngày tạo và cập nhật
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_packages');
    }
};
