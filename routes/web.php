<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicPaymentController;

// Storefront (Buyer POV)
Route::get('/', [App\Http\Controllers\StoreController::class, 'index'])->name('store.index');
Route::get('/buy/{category}', [App\Http\Controllers\StoreController::class, 'showCategory'])->name('store.category');
Route::post('/buy', [App\Http\Controllers\StoreController::class, 'purchase'])->name('store.purchase');

// Customer Auth & History
Route::prefix('customer')->name('customer.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [App\Http\Controllers\Customer\AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [App\Http\Controllers\Customer\AuthController::class, 'login'])->name('login.submit');
        Route::get('register', [App\Http\Controllers\Customer\AuthController::class, 'showRegister'])->name('register');
        Route::post('register', [App\Http\Controllers\Customer\AuthController::class, 'register'])->name('register.submit');
    });

    Route::post('logout', [App\Http\Controllers\Customer\AuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware('auth')->group(function () {
        Route::get('history', [App\Http\Controllers\Customer\HistoryController::class, 'index'])->name('history');
        Route::get('profile', [App\Http\Controllers\Customer\ProfileController::class, 'index'])->name('profile');
        Route::get('inbox', [App\Http\Controllers\Customer\InboxController::class, 'index'])->name('inbox');
        Route::get('inbox/unread-count', [App\Http\Controllers\Customer\InboxController::class, 'getUnreadCount'])->name('inbox.unread');
    });
});

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

// Consumer Routes (Top Up)
Route::middleware('auth')->group(function () {
    Route::get('/topup', [\App\Http\Controllers\ConsumerTransactionController::class, 'topUp'])->name('transaction.topup');
    Route::post('/topup', [\App\Http\Controllers\ConsumerTransactionController::class, 'processTopUp'])->name('transaction.processTopUp');
});

// Public Routes (Checkout & Callback)
// Public Routes (Checkout)
Route::get('checkout/{reference}', [App\Http\Controllers\CheckoutController::class, 'show'])->name('checkout.show');
Route::get('checkout/{reference}/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
Route::get('checkout/{reference}/status', [App\Http\Controllers\CheckoutController::class, 'checkStatus'])->name('checkout.status');
Route::post('checkout/{reference}/simulate', [App\Http\Controllers\CheckoutController::class, 'simulatePay'])->name('checkout.simulate');
Route::post('checkout/{reference}/pay-balance', [App\Http\Controllers\CheckoutController::class, 'payWithBalance'])->name('checkout.pay_balance')->middleware('auth');
Route::get('checkout/{reference}/cancel', [App\Http\Controllers\CheckoutController::class, 'cancel'])->name('checkout.cancel');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Pro Routes (Real Backend)
Route::prefix('admin-pro')->name('admin_pro.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminProController::class, 'dashboard'])->name('dashboard');
    Route::get('/transactions', [\App\Http\Controllers\AdminProController::class, 'transactions'])->name('transactions');
    Route::get('/callbacks', [\App\Http\Controllers\AdminProController::class, 'callbacks'])->name('callbacks');
    Route::get('/settings', [\App\Http\Controllers\AdminProController::class, 'settings'])->name('settings');

    // Keep others pointing to frontend controller if not yet implemented
    Route::get('/merchants', [\App\Http\Controllers\AdminProController::class, 'merchants'])->name('merchants');
    Route::get('/api', [\App\Http\Controllers\AdminProController::class, 'api'])->name('api');
    Route::post('/api/regenerate', [\App\Http\Controllers\AdminProController::class, 'regenerateKey'])->name('api.regenerate');

    // Keep others pointing to frontend controller if not yet implemented
    Route::get('/settlements', [\App\Http\Controllers\AdminProController::class, 'settlements'])->name('settlements');
    Route::get('/risk', [\App\Http\Controllers\AdminProController::class, 'risk'])->name('risk');
    Route::get('/balance', [\App\Http\Controllers\AdminProController::class, 'balance'])->name('balance');
    Route::get('/balance/top-up', [\App\Http\Controllers\AdminFrontendController::class, 'topUp'])->name('balance.top_up');
    Route::get('/balance/withdraw', [\App\Http\Controllers\AdminFrontendController::class, 'withdraw'])->name('balance.withdraw');
    Route::get('/promo', [\App\Http\Controllers\AdminProController::class, 'promo'])->name('promo');

    // Account Group
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\AdminFrontendController::class, 'profile'])->name('profile');
        Route::get('/ip-whitelist', [\App\Http\Controllers\AdminFrontendController::class, 'ipWhitelist'])->name('ip_whitelist');
        Route::get('/users', [\App\Http\Controllers\AdminFrontendController::class, 'users'])->name('users');
        Route::get('/activity', [\App\Http\Controllers\AdminFrontendController::class, 'activityLog'])->name('activity');
    });

    Route::get('/settings', [\App\Http\Controllers\AdminFrontendController::class, 'settings'])->name('settings');
    Route::post('/chatbot/send', [\App\Http\Controllers\AdminPro\ChatbotController::class, 'sendMessage'])->name('chatbot.send');
});

// Gateway Simulator (Real-world mimic)
Route::get('/gateway/simulate-scan/{reference}', [App\Http\Controllers\Gateway\SimulatorController::class, 'show'])->name('gateway.simulator.show');
Route::post('/gateway/simulate-scan/{reference}', [App\Http\Controllers\Gateway\SimulatorController::class, 'pay'])->name('gateway.simulator.pay');
