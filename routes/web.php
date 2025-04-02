<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

use App\Http\Controllers\AtmDepositController;
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\User\CardDepositController;
use App\Http\Controllers\User\GameAccountController;
use App\Http\Controllers\User\GameCategoryController;
use App\Http\Controllers\User\GameServiceController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\LuckyCategoryController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ServiceOrderController;
use App\Http\Controllers\User\RandomCategoryController;
use App\Http\Controllers\User\RandomAccountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/api.php';
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name(name: 'index');
        Route::get('/change-password', [ProfileController::class, 'viewChangePassword'])->name('change-password');

        Route::get('/services-history', [ProfileController::class, 'servicesHistory'])->name('services-history');
        Route::get('/transaction-history', [ProfileController::class, 'transactionHistory'])->name('transaction-history');
        Route::get('/purchased-accounts', [ProfileController::class, 'purchasedAccounts'])->name('purchased-accounts');

        // Đổi lại thành random
        Route::get('/purchased-random-accounts', [ProfileController::class, 'purchasedRandomAccounts'])->name('purchased-random-accounts');

        Route::get('/deposit/card', [CardDepositController::class, 'showCardDepositForm'])->name('deposit-card');
        Route::get('/deposit/atm', [AtmDepositController::class, 'index'])->name('deposit-atm');
        Route::post('/deposit/card', [CardDepositController::class, 'processCardDeposit']);
        Route::get('/service-history/{id}', [ProfileController::class, 'getServiceDetail'])
            ->name('service.detail');
    });
});
Route::prefix('category')->name('category.')->group(function () {
    Route::get('/', [GameCategoryController::class, 'showAll'])->name('show-all');
    Route::get('/{slug}', [GameCategoryController::class, 'index'])->name('index');
});
Route::prefix('account')->name('account.')->group(function () {
    Route::get('/{id}', [GameAccountController::class, 'show'])->name(name: 'show');
    Route::post('/{id}/purchase', [GameAccountController::class, 'purchase'])->name('purchase');
});
Route::prefix('service')->name('service.')->group(function () {
    Route::get('/', [GameServiceController::class, 'showAll'])->name('show-all');
    Route::get('/{slug}', [GameServiceController::class, 'show'])->name('show');
    Route::post('/{slug}/order', [ServiceOrderController::class, 'processOrder'])->name('order');
});

// Routes for random categories
Route::prefix('random')->name('random.')->group(function () {
    Route::get('/', [RandomCategoryController::class, 'showAll'])->name('show-all');
    Route::get('/account/{id}', [RandomAccountController::class, 'show'])->name('account.show');
    Route::post('/account/{id}/purchase', [RandomAccountController::class, 'purchase'])->name('account.purchase');
    Route::get('/{slug}', [RandomCategoryController::class, 'index'])->name('index');
});

// Routes for lucky wheel categories
Route::prefix('lucky')->name('lucky.')->group(function () {
    Route::get('/', [LuckyCategoryController::class, 'showAll'])->name('show-all');
    Route::get('/wheel/{id}', [LuckyCategoryController::class, 'index'])->name('index');
    Route::post('/wheel/{id}/spin', [LuckyCategoryController::class, 'spin'])->name('spin')->middleware('auth');
});

// Discount code routes
Route::post('/discount-code/validate', [DiscountCodeController::class, 'validateCode'])->name('discount.validate');
