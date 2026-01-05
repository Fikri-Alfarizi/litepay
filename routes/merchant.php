<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Merchant\DashboardController;
use App\Http\Controllers\Merchant\InvoiceController;
use App\Http\Controllers\Merchant\TransactionController; // Assuming merchant also sees transactions separated

Route::get('/dashboard', [DashboardController::class, 'index'])->name('merchant.dashboard');

Route::prefix('invoices')->name('merchant.invoices.')->group(function () {
    Route::get('/', [InvoiceController::class, 'index'])->name('index');
    Route::get('/create', [InvoiceController::class, 'create'])->name('create');
    Route::post('/', [InvoiceController::class, 'store'])->name('store');
    Route::get('/{invoice}', [InvoiceController::class, 'detail'])->name('detail');
});
