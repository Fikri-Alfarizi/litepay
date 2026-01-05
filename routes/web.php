<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicPaymentController;

// Storefront (Buyer POV)
Route::get('/', [App\Http\Controllers\StoreController::class, 'index'])->name('store.index');
Route::get('/buy/{category}', [App\Http\Controllers\StoreController::class, 'showCategory'])->name('store.category');
Route::post('/buy', [App\Http\Controllers\StoreController::class, 'purchase'])->name('store.purchase');

// Merchant & Admin Dashboard Redirections (Hidden manually for now inside auth logic if you want)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('merchants', App\Http\Controllers\Admin\MerchantController::class)->only(['index', 'show', 'update']);
    Route::resource('transactions', App\Http\Controllers\Admin\TransactionController::class)->only(['index', 'show', 'update']);
});

// Merchant Routes
Route::prefix('merchant')->name('merchant.')->group(function () {

    // Auth Routes
    Route::middleware('guest')->group(function () {
        Route::get('login', [App\Http\Controllers\Merchant\AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [App\Http\Controllers\Merchant\AuthController::class, 'login'])->name('login.submit');
        Route::get('register', [App\Http\Controllers\Merchant\AuthController::class, 'showRegister'])->name('register');
        Route::post('register', [App\Http\Controllers\Merchant\AuthController::class, 'register'])->name('register.submit');
    });

    Route::post('logout', [App\Http\Controllers\Merchant\AuthController::class, 'logout'])->name('logout')->middleware('auth');

    // Protected Merchant Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Merchant\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('invoices', App\Http\Controllers\Merchant\InvoiceController::class)->parameters(['invoices' => 'transaction']);

        Route::resource('transactions', App\Http\Controllers\Merchant\TransactionController::class)->only(['index', 'show']);
    });
});

// Public Routes (Checkout & Callback)
Route::get('checkout/{reference}', [App\Http\Controllers\CheckoutController::class, 'show'])->name('checkout.show');
Route::post('checkout/{reference}', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
Route::get('checkout/{reference}/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

Route::post('callback', [App\Http\Controllers\CallbackController::class, 'handle'])->name('callback');

// Demo Route for viewing Checkout UI
Route::get('/purchase-demo', function () {
    $mockMerchant = new \App\Models\Merchant([
        'name' => 'Store of the Future',
    ]);
    $mockMerchant->setRelation('user', new \App\Models\User(['email' => 'contact@futurestore.com']));

    $transaction = new \App\Models\Transaction([
        'reference_id' => 'DEMO-' . rand(1000, 9999),
        'amount' => 150000,
        'status' => 'pending',
    ]);
    $transaction->setRelation('merchant', $mockMerchant);

    return view('checkout.show', compact('transaction'));
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

