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
        Schema::create('random_category_accounts', function (Blueprint $table) {
            $table->id(); // ID tự động tăng, khóa chính
            $table->foreignId('random_category_id')->constrained('random_categories')->cascadeOnDelete(); // ID danh mục ngẫu nhiên - Khóa ngoại liên kết với bảng random_categories, xóa cấp liên
            $table->string('account_name')->nullable(); // Tên tài khoản game - Tên đăng nhập của tài khoản (có thể để trống nếu chưa có)
            $table->string('password')->nullable(); // Mật khẩu game - Mật khẩu của tài khoản game (có thể để trống nếu chưa có)
            $table->bigInteger('price'); // Giá tiền - Tổng giá bán của tài khoản (VD: 500000 VNĐ)
            $table->enum('status', ['available', 'sold'])->default('available'); // Trạng thái - "available": Chưa bán, "sold": Đã bán
            $table->integer('server'); // Máy chủ - Số hoặc mã máy chủ mà tài khoản thuộc về (VD: 1, 2, 3... hoặc tên server)
            $table->foreignId('buyer_id')->nullable()->constrained('users')->cascadeOnDelete(); // ID người mua - Khóa ngoại liên kết với bảng users, null nếu chưa có ai mua, xóa cấp liên
            $table->text('note')->nullable(); // Ghi chú - Thông tin bổ sung về tài khoản (VD: "Tài khoản có skin hiếm")
            $table->text('note_buyer')->nullable(); // Ghi chú cho người mua
            $table->string('thumbnail')->nullable(); // Ảnh đại diện - Đường dẫn hoặc tên file ảnh minh họa tài khoản (có thể null)
            $table->timestamps(); // Thời gian tạo và cập nhật - Tự động thêm created_at và updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('random_category_accounts');
    }
};