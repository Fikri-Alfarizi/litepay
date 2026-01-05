<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MerchantController;
use App\Http\Controllers\Admin\TransactionController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::prefix('merchants')->name('admin.merchants.')->group(function () {
    Route::get('/', [MerchantController::class, 'index'])->name('index');
    Route::get('/{merchant}', [MerchantController::class, 'show'])->name('show');
});

Route::prefix('transactions')->name('admin.transactions.')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::get('/{transaction}', [TransactionController::class, 'detail'])->name('detail'); // user asked for detail
});
