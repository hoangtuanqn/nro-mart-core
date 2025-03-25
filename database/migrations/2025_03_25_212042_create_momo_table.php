<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('momo', function (Blueprint $table) {
            $table->id();
            $table->string('request_id', 64)->nullable();
            $table->text('transaction_id')->nullable();
            $table->text('partner_id')->nullable();
            $table->text('partner_name')->nullable();
            $table->text('amount')->nullable();
            $table->text('comment')->nullable();
            $table->timestamp('transaction_time')->nullable();
            $table->string('username', 32)->nullable();
            $table->foreign('username')->references('username')->on('users');
            $table->string('status', 32)->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('momo');
    }
};