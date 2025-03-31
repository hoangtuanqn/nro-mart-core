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
use App\Http\Controllers\Admin\GameServiceController;
use App\Http\Controllers\Admin\ServicePackageController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\BankAccountController;
use Illuminate\Support\Facades\Route;
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');
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
        Route::get('/edit/{service}', [GameServiceController::class, 'edit'])->name('edit');
        Route::put('/update/{service}', [GameServiceController::class, 'update'])->name('update');
        Route::delete('/delete/{service}', [GameServiceController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('packages')->name('packages.')->group(function () {
        Route::get('/', [ServicePackageController::class, 'index'])->name('index');
        Route::get('/service/{service_id}', [ServicePackageController::class, 'index'])->name('service');
        Route::get('/create', [ServicePackageController::class, 'create'])->name('create');
        Route::get('/create/{service_id}', [ServicePackageController::class, 'create'])->name('createForService');
        Route::post('/store', [ServicePackageController::class, 'store'])->name('store');
        Route::get('/edit/{package}', [ServicePackageController::class, 'edit'])->name('edit');
        Route::put('/update/{package}', [ServicePackageController::class, 'update'])->name('update');
        Route::delete('/delete/{package}', [ServicePackageController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        // Cài đặt chung
        Route::get('/general', [ConfigController::class, 'general'])->name('general');
        Route::post('/general', [ConfigController::class, 'updateGeneral'])->name('general.update');

        // Cài đặt email
        Route::get('/email', [ConfigController::class, 'email'])->name('email');
        Route::post('/email', [ConfigController::class, 'updateEmail'])->name('email.update');

        // Cài đặt thanh toán
        Route::get('/payment', [ConfigController::class, 'payment'])->name('payment');
        Route::post('/payment', [ConfigController::class, 'updatePayment'])->name('payment.update');
    });

    // Quản lý tài khoản ngân hàng
    Route::prefix('bank-accounts')->name('bank-accounts.')->group(function () {
        Route::get('/', [BankAccountController::class, 'index'])->name('index');
        Route::get('/create', [BankAccountController::class, 'create'])->name('create');
        Route::post('/store', [BankAccountController::class, 'store'])->name('store');
        Route::get('/edit/{bankAccount}', [BankAccountController::class, 'edit'])->name('edit');
        Route::put('/update/{bankAccount}', [BankAccountController::class, 'update'])->name('update');
        Route::delete('/delete/{bankAccount}', [BankAccountController::class, 'destroy'])->name('destroy');
    });
});
