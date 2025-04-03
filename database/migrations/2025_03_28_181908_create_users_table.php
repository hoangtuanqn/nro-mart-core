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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID người dùng
            $table->string('username')->unique(); // Tài khoản
            $table->string('password'); // Mật khẩu (hashed)
            $table->string('email')->unique(); // Email
            $table->string('google_id')->nullable(); // Lưu ID Google khi login bằng Google Social
            $table->string('facebook_id')->nullable(); // Lưu ID Facebook khi login bằng Facebook Social
            $table->enum('role', ['member', 'admin'])->default('member'); // Cấp bậc
            $table->bigInteger('balance')->default(0); // Số tiền hiện có
            $table->bigInteger('total_deposited')->default(0); // Số tiền đã nạp
            $table->bigInteger('gold')->default(0); // Số vàng hiện có
            $table->bigInteger('gem')->default(0); // Số gem hiện có
            $table->boolean('banned')->default(false); // Banned (1: đã ban, 0: chưa ban)
            $table->string('ip_address')->nullable(); // Địa chỉ IP
            $table->rememberToken(); // Token ghi nhớ đăng nhập
            $table->timestamp('email_verified_at')->nullable(); // Xác thực email
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
