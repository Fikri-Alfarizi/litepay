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

Route::get('/payment/pay/{reference_id}', [PublicPaymentController::class, 'show'])->name('payment.pay');
Route::post('/payment/pay/{reference_id}', [PublicPaymentController::class, 'process'])->name('payment.process');

// Admin Frontend Showcase Routes
Route::prefix('admin-pro')->name('admin_pro.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminFrontendController::class, 'dashboard'])->name('dashboard');
    Route::get('/merchants', [\App\Http\Controllers\AdminFrontendController::class, 'merchants'])->name('merchants');
    Route::get('/transactions', [\App\Http\Controllers\AdminFrontendController::class, 'transactions'])->name('transactions');
    Route::get('/api', [\App\Http\Controllers\AdminFrontendController::class, 'apiManagement'])->name('api');
    Route::get('/callbacks', [\App\Http\Controllers\AdminFrontendController::class, 'callbacks'])->name('callbacks');
    Route::get('/settlements', [\App\Http\Controllers\AdminFrontendController::class, 'settlements'])->name('settlements');
    Route::get('/risk', [\App\Http\Controllers\AdminFrontendController::class, 'risk'])->name('risk');
    Route::get('/balance', [\App\Http\Controllers\AdminFrontendController::class, 'balance'])->name('balance');
    Route::get('/balance/top-up', [\App\Http\Controllers\AdminFrontendController::class, 'topUp'])->name('balance.top_up');
    Route::get('/balance/withdraw', [\App\Http\Controllers\AdminFrontendController::class, 'withdraw'])->name('balance.withdraw');
    Route::get('/promo', [\App\Http\Controllers\AdminFrontendController::class, 'promo'])->name('promo');
    
    // Account Group
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\AdminFrontendController::class, 'profile'])->name('profile');
        Route::get('/ip-whitelist', [\App\Http\Controllers\AdminFrontendController::class, 'ipWhitelist'])->name('ip_whitelist');
        Route::get('/users', [\App\Http\Controllers\AdminFrontendController::class, 'users'])->name('users');
        Route::get('/activity', [\App\Http\Controllers\AdminFrontendController::class, 'activityLog'])->name('activity');
    });

    Route::get('/settings', [\App\Http\Controllers\AdminFrontendController::class, 'settings'])->name('settings');
});

