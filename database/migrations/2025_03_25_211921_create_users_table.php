<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('token')->nullable();
            $table->integer('balance')->default(0);
            $table->enum('role', ['member', 'admin'])->default('member');
            $table->tinyInteger('banned')->default(0);
            $table->string('email')->nullable();
            $table->string('referral_code')->nullable();
            $table->integer('daily_points')->default(0);
            $table->string('otp')->nullable();
            $table->string('ip_address')->nullable();
            $table->float('discount')->default(0);
            $table->integer('total_spent')->default(0);
            $table->integer('total_deposited')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};