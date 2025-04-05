<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // ID tự động tăng, khóa chính
            $table->string('class_favicon'); // Class favicon - Tên class từ Font Awesome để hiển thị biểu tượng (VD: "fas fa-bell", "fas fa-info-circle")
            $table->text('content'); // Nội dung thông báo - Nội dung hiển thị bên cạnh biểu tượng (VD: "Khuyến mãi 10% khi nạp tiền!")
            $table->timestamps(); // Thời gian tạo và cập nhật - Tự động thêm created_at và updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};