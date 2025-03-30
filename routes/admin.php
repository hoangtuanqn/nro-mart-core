<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('index');
    Route::prefix('users')->name('users.')->group(function () {

        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit')->where('id', '[0-9]+');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy')->where('id', '[0-9]+');

    });

});