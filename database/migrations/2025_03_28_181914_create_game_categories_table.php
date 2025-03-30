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
        Schema::create('game_categories', function (Blueprint $table) {
            $table->id(); // ID danh mục
            $table->string('name'); // Tên danh mục
            $table->string('slug'); // URL friendly version of name
            $table->string('thumbnail'); // Ảnh đại diện
            $table->text('description'); // Mô tả (chứa HTML/JS)
            $table->boolean('active')->default(true); // Trạng thái (1: Hoạt động, 0: Ẩn)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_categories');
    }
};
