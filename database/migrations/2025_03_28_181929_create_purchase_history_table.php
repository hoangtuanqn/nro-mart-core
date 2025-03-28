<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_history', function (Blueprint $table) {
            $table->id(); // ID giao dịch
            $table->foreignId('user_id')->constrained(); // Người mua
            $table->foreignId('game_account_id')->constrained(); // Tài khoản mua
            $table->bigInteger('amount'); // Số tiền
            $table->text('account_details')->nullable(); // Chi tiết tài khoản khi mua
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_history');
    }
};
