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
        Schema::create('money_transactions', function (Blueprint $table) {
            $table->id(); // ID giao dịch
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Người dùng
            $table->enum('type', ['deposit', 'withdraw', 'purchase', 'refund']); // Loại giao dịch
            $table->bigInteger('amount'); // Số tiền
            $table->bigInteger('balance_before'); // Số dư trước giao dịch
            $table->bigInteger('balance_after'); // Số dư sau giao dịch
            $table->text('description')->nullable(); // Mô tả
            $table->string('reference_id')->nullable(); // Mã tham chiếu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('money_transactions');
    }
};
