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
        Schema::create('game_services', function (Blueprint $table) {
            $table->id(); // ID tự động tăng
            $table->string('name'); // Tên dịch vụ (VD: Bán vàng, Bán ngọc, Cày cấp...)
            $table->string('slug')->unique(); // Đường dẫn SEO
            $table->string('thumbnail'); // Ảnh đại diện dịch vụ
            $table->text('description')->nullable(); // Mô tả chi tiết dịch vụ
            $table->enum('type', ['gold', 'gem', 'leveling']); // Loại dịch vụ: gold (bán vàng), gem (bán ngọc), leveling (cày thuê)
            $table->boolean('active')->default(true); // Trạng thái (1: hiển thị, 0: ẩn)
            $table->timestamps(); // Ngày tạo và cập nhật
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_services');
    }
};