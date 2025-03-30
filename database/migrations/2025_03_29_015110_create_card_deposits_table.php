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
        Schema::create('card_deposits', function (Blueprint $table) {
            $table->id(); // ID tự động tăng
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->cascadeOnDelete(); // ID người dùng, liên kết với bảng users
            $table->string('telco'); // Nhà mạng thẻ cào
            $table->integer('amount'); // Mệnh giá thẻ nạp
            $table->integer('received_amount'); // Số tiền thực nhận
            $table->string('serial'); // Số serial của thẻ
            $table->string('pin'); // Mã pin của thẻ
            $table->bigInteger('request_id'); // Mã pin của thẻ
            $table->enum('status', ['success', 'error', 'processing'])->default('processing'); // Trạng thái nạp thẻ
            $table->text('response')->nullable(); // Phản hồi từ hệ thống (có thể để trống)
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_deposits');
    }
};