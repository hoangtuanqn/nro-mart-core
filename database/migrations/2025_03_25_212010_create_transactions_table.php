<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('balance_before')->nullable();
            $table->integer('amount_changed')->nullable();
            $table->integer('balance_after')->nullable();
            $table->timestamp('transaction_time')->nullable();
            $table->text('description')->nullable();
            $table->string('username');
            $table->foreign('username')->references('username')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};