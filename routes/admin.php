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
use App\Http\Controllers\Admin\RandomCategoryController;
use App\Http\Controllers\Admin\RandomCategoryAccountController;
use App\Http\Controllers\Admin\DiscountCodeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\MoneyWithdrawalController;
use App\Http\Controllers\Admin\ResourceWithdrawalController;
use App\Http\Controllers\Admin\LuckyWheelController;

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('show')->where('id', '[0-9]+');
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

    // Routes for Random Categories management
    Route::prefix('random-categories')->name('random-categories.')->group(function () {
        Route::get('/', [RandomCategoryController::class, 'index'])->name('index');
        Route::get('/create', [RandomCategoryController::class, 'create'])->name('create');
        Route::post('/store', [RandomCategoryController::class, 'store'])->name('store');
        Route::get('/edit/{category}', [RandomCategoryController::class, 'edit'])->name('edit');
        Route::put('/update/{category}', [RandomCategoryController::class, 'update'])->name('update');
        Route::delete('/delete/{category}', [RandomCategoryController::class, 'destroy'])->name('destroy');
    });

    // Routes for Random Accounts management
    Route::prefix('random-accounts')->name('random-accounts.')->group(function () {
        Route::get('/', [RandomCategoryAccountController::class, 'index'])->name('index');
        Route::get('/create', [RandomCategoryAccountController::class, 'create'])->name('create');
        Route::post('/store', [RandomCategoryAccountController::class, 'store'])->name('store');
        Route::get('/edit/{account}', [RandomCategoryAccountController::class, 'edit'])->name('edit');
        Route::put('/update/{account}', [RandomCategoryAccountController::class, 'update'])->name('update');
        Route::delete('/delete/{account}', [RandomCategoryAccountController::class, 'destroy'])->name('destroy');
    });

    // Routes for Discount Codes management
    Route::prefix('discount-codes')->name('discount-codes.')->group(function () {
        Route::get('/', [DiscountCodeController::class, 'index'])->name('index');
        Route::get('/create', [DiscountCodeController::class, 'create'])->name('create');
        Route::post('/store', [DiscountCodeController::class, 'store'])->name('store');
        Route::get('/edit/{discountCode}', [DiscountCodeController::class, 'edit'])->name('edit');
        Route::put('/update/{discountCode}', [DiscountCodeController::class, 'update'])->name('update');
        Route::delete('/delete/{discountCode}', [DiscountCodeController::class, 'destroy'])->name('destroy');
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

    // Quản lý tài khoản ngân hàng
    Route::prefix('bank-accounts')->name('bank-accounts.')->group(function () {
        Route::get('/', [BankAccountController::class, 'index'])->name('index');
        Route::get('/create', [BankAccountController::class, 'create'])->name('create');
        Route::post('/store', [BankAccountController::class, 'store'])->name('store');
        Route::get('/edit/{bankAccount}', [BankAccountController::class, 'edit'])->name('edit');
        Route::put('/update/{bankAccount}', [BankAccountController::class, 'update'])->name('update');
        Route::delete('/delete/{bankAccount}', [BankAccountController::class, 'destroy'])->name('destroy');
    });

    // History section
    Route::prefix('history')->name('history.')->group(function () {
        Route::get('transactions', [HistoryController::class, 'transactions'])->name('transactions');
        Route::get('accounts', [HistoryController::class, 'accounts'])->name('accounts');
        Route::get('random-accounts', [HistoryController::class, 'randomAccounts'])->name('random-accounts');
        Route::get('services', [HistoryController::class, 'services'])->name('services');
        Route::get('deposits/bank', [HistoryController::class, 'bankDeposits'])->name('deposits.bank');
        Route::get('deposits/card', [HistoryController::class, 'cardDeposits'])->name('deposits.card');
        Route::get('discount-usages', [HistoryController::class, 'discountUsages'])->name('discount-usages');
    });

    // Withdrawal section
    Route::prefix('withdrawals')->name('withdrawals.')->group(function () {
        Route::get('/money', [MoneyWithdrawalController::class, 'index'])->name('index');
        Route::post('/money/{withdrawal}/approve', [MoneyWithdrawalController::class, 'approve'])->name('approve');
        Route::post('/money/{withdrawal}/reject', [MoneyWithdrawalController::class, 'reject'])->name('reject');

        // Gold and Gem withdrawal routes
        Route::prefix('resources')->name('resources.')->group(function () {
            Route::get('/', [ResourceWithdrawalController::class, 'index'])->name('index');
            Route::post('/{withdrawal}/approve', [ResourceWithdrawalController::class, 'approve'])->name('approve');
            Route::post('/{withdrawal}/reject', [ResourceWithdrawalController::class, 'reject'])->name('reject');
        });
    });

    // Routes for Lucky Wheels management
    Route::prefix('lucky-wheels')->name('lucky-wheels.')->group(function () {
        Route::get('/', [LuckyWheelController::class, 'index'])->name('index');
        Route::get('/create', [LuckyWheelController::class, 'create'])->name('create');
        Route::post('/store', [LuckyWheelController::class, 'store'])->name('store');
        Route::get('/edit/{luckyWheel}', [LuckyWheelController::class, 'edit'])->name('edit');
        Route::put('/update/{luckyWheel}', [LuckyWheelController::class, 'update'])->name('update');
        Route::delete('/delete/{luckyWheel}', [LuckyWheelController::class, 'destroy'])->name('destroy');
        Route::get('/history', [LuckyWheelController::class, 'history'])->name('history');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        // Cài đặt chung
        Route::get('/general', [ConfigController::class, 'general'])->name('general');
        Route::post('/general', [ConfigController::class, 'updateGeneral'])->name('general.update');

        // Cài đặt mạng xã hội
        Route::get('/social', [ConfigController::class, 'social'])->name('social');
        Route::post('/social', [ConfigController::class, 'updateSocial'])->name('social.update');

        // Cài đặt email
        Route::get('/email', [ConfigController::class, 'email'])->name('email');
        Route::post('/email', [ConfigController::class, 'updateEmail'])->name('email.update');
        Route::post('/email/test', [ConfigController::class, 'testEmail'])->name('email.test');

        // Cài đặt thanh toán
        Route::get('/payment', [ConfigController::class, 'payment'])->name('payment');
        Route::post('/payment', [ConfigController::class, 'updatePayment'])->name('payment.update');

        // Cài đặt đăng nhập
        Route::get('/login', [ConfigController::class, 'login'])->name('login');
        Route::post('/login', [ConfigController::class, 'updateLogin'])->name('login.update');

        // Quản lý thông báo
        Route::get('/notifications', [ConfigController::class, 'notifications'])->name('notifications');
        Route::get('/notifications/create', [App\Http\Controllers\Admin\NotificationController::class, 'create'])->name('notifications.create');
        Route::post('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('notifications.store');
        Route::get('/notifications/{notification}/edit', [App\Http\Controllers\Admin\NotificationController::class, 'edit'])->name('notifications.edit');
        Route::put('/notifications/{notification}', [App\Http\Controllers\Admin\NotificationController::class, 'update'])->name('notifications.update');
        Route::delete('/notifications/{notification}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
    });

});
