<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->nullable();
            $table->string('username', 32);
            $table->foreign('username')->references('username')->on('users');
            $table->string('card_type', 32);
            $table->integer('denomination');
            $table->integer('actual_amount')->default(0);
            $table->mediumText('serial');
            $table->mediumText('pin');
            $table->string('status', 32);
            $table->mediumText('notes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cards');
    }
};