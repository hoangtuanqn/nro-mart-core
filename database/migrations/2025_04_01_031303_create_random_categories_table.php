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
        Schema::create('random_categories', function (Blueprint $table) {
            $table->id(); // ID tự động tăng, khóa chính
            $table->string('name'); // Tên danh mục - Tên của danh mục ngẫu nhiên (VD: "Danh mục VIP", "Danh mục giá rẻ")
            $table->string('slug')->unique(); // Đường dẫn SEO - Chuỗi duy nhất dùng cho URL (VD: "danh-muc-vip")
            $table->string('thumbnail'); // Ảnh đại diện - Đường dẫn hoặc tên file ảnh minh họa danh mục
            $table->text('description')->nullable(); // Mô tả - Thông tin chi tiết về danh mục (VD: "Danh mục chứa các tài khoản cao cấp")
            $table->boolean('active')->default(true); // Trạng thái - 1: Hiển thị, 0: Ẩn khỏi giao diện người dùng
            $table->timestamps(); // Thời gian tạo và cập nhật - Tự động thêm created_at và updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('random_categories');
    }
};