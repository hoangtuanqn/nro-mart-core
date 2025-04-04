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
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tạo bảng discount_codes để lưu trữ thông tin mã giảm giá
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id(); // Khóa chính tự động tăng
            $table->string('code')->unique(); // Mã giảm giá, phải là duy nhất
            $table->enum('discount_type', ['percentage', 'fixed_amount'])->default('percentage'); // Loại giảm giá: phần trăm hoặc số tiền cố định
            $table->decimal('discount_value', 10, 2)->default(0); // Giá trị giảm giá
            $table->decimal('max_discount_value', 10, 2)->nullable(); // Giá trị giảm giá tối đa
            $table->decimal('min_purchase_amount', 10, 2)->default(0); // Số tiền mua tối thiểu để áp dụng mã
            $table->enum('is_active', ['1', '0'])->default('1'); // Trạng thái của mã: hoạt động hoặc không hoạt động
            $table->integer('usage_limit')->nullable(); // Giới hạn số lần sử dụng mã
            $table->integer('usage_count')->default(0); // Số lần đã sử dụng mã
            $table->integer('per_user_limit')->nullable(); // Giới hạn sử dụng mã cho mỗi người dùng
            $table->enum('applicable_to', ['account', 'random_account', 'service'])->nullable(); // Đối tượng áp dụng mã
            $table->json('item_ids')->nullable(); // Danh sách ID các item có thể áp dụng mã giảm giá
            $table->timestamp('expire_date')->nullable(); // Ngày hết hạn của mã
            $table->text('description')->nullable(); // Mô tả về mã giảm giá
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_codes');
    }
};
