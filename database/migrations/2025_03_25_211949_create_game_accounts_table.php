<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('game_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_category_id')->constrained('sub_categories');
            $table->text('login_account')->nullable();
            $table->text('login_password')->nullable();
            $table->text('details')->nullable();
            $table->string('buyer_username')->nullable();
            $table->foreign('buyer_username')->references('username')->on('users');
            $table->string('receiver')->nullable();
            $table->string('transaction_time')->nullable();
            $table->string('title')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('price')->nullable();
            $table->longText('image_list')->nullable();
            $table->string('collaborator', 250)->nullable();
            $table->enum('status', ['available', 'sold', 'reserved'])->default('available');
            $table->integer('server')->nullable();
            $table->enum('planet', ['Xayda', 'TraiDat', 'Namek'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('game_accounts');
    }
};