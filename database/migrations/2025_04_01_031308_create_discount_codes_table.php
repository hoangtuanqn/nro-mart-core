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
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id(); // ID tự động tăng, khóa chính
            $table->string('code')->unique(); // Mã giảm giá - Chuỗi duy nhất (VD: "WELCOME10")
            $table->string('description')->nullable(); // Mô tả - Thông tin về mã giảm giá (VD: "Mã giảm giá 10% cho người dùng mới")
            $table->enum('type', ['percentage', 'fixed'])->default('percentage'); // Loại giảm giá - 'percentage': phần trăm, 'fixed': số tiền cố định
            $table->decimal('value', 10, 2); // Giá trị giảm giá - Số phần trăm hoặc số tiền cố định
            $table->decimal('max_discount', 10, 2)->default(0); // Giảm giá tối đa - Giới hạn số tiền tối đa được giảm (0 = không giới hạn)
            $table->integer('usage_limit')->default(1); // Giới hạn sử dụng - Số lần mã có thể được sử dụng
            $table->boolean('is_active')->default(true); // Trạng thái - true: Mã có thể sử dụng, false: Mã không hoạt động
            $table->timestamp('expires_at')->nullable(); // Ngày hết hạn - Thời điểm mã hết hạn (null = không hết hạn)
            $table->timestamps(); // Thời gian tạo và cập nhật - created_at và updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discount_codes');
    }
};
