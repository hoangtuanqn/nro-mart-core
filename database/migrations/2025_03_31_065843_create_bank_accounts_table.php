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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id(); // ID tự động tăng
            $table->string('bank_name'); // Tên ngân hàng
            $table->string('account_name'); // Tên ngân hàng
            $table->string('account_number'); // Số tài khoản (đảm bảo duy nhất)
            $table->string('branch')->nullable(); // Chi nhánh (có thể null)
            $table->text('note')->nullable(); // Ghi chú
            $table->boolean('is_active')->default(true); // Trạng thái hiển thị (true: hiển thị, false: ẩn)
            $table->boolean('auto_confirm')->default(false); // Xác nhận tự động cộng tiền cho khách hàng (Cho phép chạy cron)
            $table->string('prefix')->default('naptien'); // Prefix cú pháp nạp tiền
            $table->string('access_token')->nullable(); // Access Token bên SePay.VN
            $table->timestamps(); // Tạo trường created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
