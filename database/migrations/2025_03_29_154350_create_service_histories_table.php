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
        Schema::create('service_histories', function (Blueprint $table) {
            $table->id(); // ID tự động tăng
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Người mua (liên kết bảng users)
            $table->foreignId('game_service_id')->constrained('game_services')->cascadeOnDelete(); // Loại dịch vụ (liên kết bảng game_services)
            $table->foreignId('service_package_id')->nullable()->constrained('service_packages')->cascadeOnDelete(); // Gói dịch vụ (có thể null)

            // Thông tin tài khoản game
            $table->string('game_account'); // Tài khoản game
            $table->string('game_password'); // Mật khẩu game
            $table->integer('server'); // Máy chủ (1-13 hoặc tên server)

            // Thông tin giao dịch
            $table->bigInteger('amount')->default(0); // Số lượng (VD: 1000 vàng, 50 ngọc)
            $table->bigInteger('price'); // Tổng tiền
            $table->string('discount_code')->nullable(); // Mã giảm giá (nếu có)
            $table->decimal('discount_amount', 10, 2)->default(0); // Số tiền được giảm

            // Trạng thái
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending'); // Trạng thái đơn hàng
            $table->text('admin_note')->nullable(); // Ghi chú từ admin

            $table->timestamps(); // Ngày tạo và cập nhật
            $table->timestamp('completed_at')->nullable(); // Thời gian hoàn thành
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_histories');
    }
};
