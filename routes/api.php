<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TransactionStatusController;
use App\Http\Controllers\Api\CallbackController; // Although callback is usually outgoing, maybe this is for testing or receiving?
// User said: "Callback Controller" in structure.
// Process: Merchant calls Payment Gateway -> PaymentController
// Gateway sends callback -> (Logic in Job)
// Maybe TransactionStatusController is for merchant to query status?

Route::middleware(['verify.api.key', 'verify.signature'])->group(function () {
    Route::post('/payment', [PaymentController::class, 'create'])->name('api.payment.create');
});

// Public or secured differently?
Route::get('/payment/status/{invoice_id}', [TransactionStatusController::class, 'check'])->name('api.payment.check');
