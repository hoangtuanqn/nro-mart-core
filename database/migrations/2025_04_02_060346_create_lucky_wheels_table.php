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
        Schema::create('lucky_wheels', function (Blueprint $table) {
            $table->id(); // ID tự động tăng, khóa chính
            $table->string('name'); // Tên vòng quay - Tên của vòng quay may mắn (VD: "Vòng quay VIP")
            $table->string('slug')->unique(); // Đường dẫn SEO - Chuỗi duy nhất dùng cho URL (VD: "vong-quay-vip")
            $table->string('thumbnail'); // Ảnh đại diện - Đường dẫn hoặc tên file ảnh minh họa vòng quay
            $table->string('wheel_image'); // Hình ảnh vòng quay
            $table->text('description')->nullable(); // Mô tả vòng quay
            $table->text('rules'); // Thể lệ vòng quay - Nội dung thể lệ, có thể chứa mã HTML (VD: "<p>Quay để nhận vàng</p>")
            $table->boolean('active')->default(true); // Trạng thái - 1: Hiển thị, 0: Ẩn khỏi giao diện người dùng
            $table->bigInteger('price_per_spin'); // Giá tiền mỗi lần quay - Giá mỗi lần quay (VD: 10000 VNĐ)
            $table->json('config'); // Cấu hình - Mảng JSON chứa 8 phần tử, mỗi phần tử là object với các trường: type (vàng/ngọc), content (nội dung hiển thị), amount (số lượng trúng)
            $table->timestamps(); // Thời gian tạo và cập nhật - Tự động thêm created_at và updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lucky_wheels');
    }
};