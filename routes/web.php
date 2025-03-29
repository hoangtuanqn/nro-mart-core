<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

use App\Http\Controllers\CardDepositController;
use App\Http\Controllers\GameAccountController;
use App\Http\Controllers\GameCategoryController;
use App\Http\Controllers\GameServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ServiceOrderController;
use App\Models\GameAccount;
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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::prefix('category')->name('category.')->group(function () {
    Route::get('/{slug}', [GameCategoryController::class, 'index'])->name('index');
});
Route::prefix('account')->name('account.')->group(function () {
    Route::get('/{id}', [GameAccountController::class, 'show'])->name(name: 'show');
    Route::post('/{id}/purchase', [GameAccountController::class, 'purchase'])->name('purchase');
});
Route::prefix('service')->name('service.')->group(function () {
    Route::get('/{slug}', [GameServiceController::class, 'show'])->name('show');
    Route::post('/{slug}/order', [ServiceOrderController::class, 'processOrder'])->name('order');
});
Route::middleware('auth')->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name(name: 'index');
        Route::get('/change-password', [ProfileController::class, 'viewChangePassword'])->name('change-password');

        Route::get('/services-history', [ProfileController::class, 'servicesHistory'])->name('services-history');
        Route::get('/transaction-history', [ProfileController::class, 'transactionHistory'])->name('transaction-history');
        Route::get('/purchased-accounts', [ProfileController::class, 'purchasedAccounts'])->name('purchased-accounts');

        Route::get('/deposit/card', [CardDepositController::class, 'showCardDepositForm'])->name('deposit-card');
        Route::post('/deposit/card', [CardDepositController::class, 'processCardDeposit']);
        Route::get('/service-history/{id}', [ProfileController::class, 'getServiceDetail'])
            ->name('profile.service.detail');
    });

    // Route::prefix('user')->name('user.')->group(function () {
    //     Route::prefix('services')->name('services.')->group(function () {
    //         Route::get('/history', [ServiceOrderController::class, 'history'])->name('history');
    //         Route::get('/order/{id}', [ServiceOrderController::class, 'orderSuccess'])->name('order.success');
    //         Route::post('/order/{id}/cancel', [ServiceOrderController::class, 'cancelOrder'])->name('order.cancel');
    //         Route::get('/order/{id}/detail', [ServiceOrderController::class, 'orderDetail'])->name('order.detail');
    //     });
    // });
});

