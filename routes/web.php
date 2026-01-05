<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicPaymentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public Payment Simulation Route
Route::get('/payment/pay/{reference_id}', [PublicPaymentController::class, 'show'])->name('payment.pay');
Route::post('/payment/pay/{reference_id}', [PublicPaymentController::class, 'process'])->name('payment.process');
