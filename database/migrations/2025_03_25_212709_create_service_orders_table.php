<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->foreign('username')->references('username')->on('users');
            $table->foreignId('service_id')->nullable()->constrained('game_services');
            $table->integer('server')->nullable();
            $table->string('game_account')->nullable();
            $table->string('game_password')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('price')->nullable();
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending');
            $table->text('notes')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->string('collaborator', 250)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_orders');
    }
};