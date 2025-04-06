<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CardDepositController;
use App\Http\Controllers\DiscountCodeController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::match(['GET', 'POST'],'/callback/card', [CardDepositController::class, 'handleCallback'])->name('callback.card');

// Discount code validation
Route::post('/discount-codes/validate', [DiscountCodeController::class, 'validateCode']);

Route::get('/auto-bank-deposit', function () {
    Artisan::call('fetch:mb-transactions');
}); // Bảo vệ route bằng middleware auth