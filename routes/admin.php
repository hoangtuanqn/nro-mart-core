<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

use App\Http\Controllers\Admin\GameAccountController;
use App\Http\Controllers\Admin\GameCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\GameServiceController;
use Illuminate\Support\Facades\Route;
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('index');
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit')->where('id', '[0-9]+');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy')->where('id', '[0-9]+');
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [GameCategoryController::class, 'index'])->name('index');
        Route::get('/create', [GameCategoryController::class, 'create'])->name('create');
        Route::post('/store', [GameCategoryController::class, 'store'])->name('store');
        Route::get('/edit/{category}', [GameCategoryController::class, 'edit'])->name('edit');
        Route::put('/update/{category}', [GameCategoryController::class, 'update'])->name('update');
        Route::delete('/delete/{category}', [GameCategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('accounts')->name('accounts.')->group(function () {
        Route::get('/', [GameAccountController::class, 'index'])->name('index');
        Route::get('/create', [GameAccountController::class, 'create'])->name('create');
        Route::post('/store', [GameAccountController::class, 'store'])->name('store');
        Route::get('/edit/{account}', [GameAccountController::class, 'edit'])->name('edit');
        Route::put('/update/{account}', [GameAccountController::class, 'update'])->name('update');
        Route::delete('/delete/{account}', [GameAccountController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [GameServiceController::class, 'index'])->name('index');
        Route::get('/create', [GameServiceController::class, 'create'])->name('create');
        Route::post('/store', [GameServiceController::class, 'store'])->name('store');
        Route::get('/edit/{account}', [GameServiceController::class, 'edit'])->name('edit');
        Route::put('/update/{account}', [GameServiceController::class, 'update'])->name('update');
        Route::delete('/delete/{account}', [GameServiceController::class, 'destroy'])->name('destroy');
    });

});