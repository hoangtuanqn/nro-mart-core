<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bank_auto', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id', 64)->nullable();
            $table->text('description')->nullable();
            $table->integer('amount')->default(0);
            $table->integer('cumulative_balance')->default(0);
            $table->timestamp('transaction_time')->nullable();
            $table->string('bank_sub_account_id', 64)->nullable();
            $table->string('username', 64)->nullable();
            $table->foreign('username')->references('username')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_auto');
    }
};