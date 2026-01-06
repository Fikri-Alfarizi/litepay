<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\PaymentService;

class StoreController extends Controller
{
    public function index()
    {
        return view('store.index');
    }

    public function showCategory(string $slug)
    {
        $categoryName = ucfirst($slug);

        // Mock Products
        $products = [];
        if ($slug === 'pulsa') {
            $products = [
                ['id' => 1, 'name' => 'Pulsa 5.000', 'amount' => 7000, 'description' => 'Masa aktif +7 hari'],
                ['id' => 2, 'name' => 'Pulsa 10.000', 'amount' => 12000, 'description' => 'Masa aktif +15 hari'],
                ['id' => 3, 'name' => 'Pulsa 25.000', 'amount' => 27000, 'description' => 'Masa aktif +30 hari'],
                ['id' => 4, 'name' => 'Pulsa 50.000', 'amount' => 52000, 'description' => 'Masa aktif +45 hari'],
                ['id' => 5, 'name' => 'Pulsa 100.000', 'amount' => 102000, 'description' => 'Masa aktif +60 hari'],
            ];
        } elseif ($slug === 'data') {
            $products = [
                ['id' => 11, 'name' => 'Daily 1GB', 'amount' => 5000, 'description' => 'Valid for 1 day'],
                ['id' => 12, 'name' => 'Weekly 5GB', 'amount' => 25000, 'description' => 'Valid for 7 days'],
                ['id' => 13, 'name' => 'Monthly 15GB', 'amount' => 50000, 'description' => 'Valid for 30 days'],
                ['id' => 14, 'name' => 'Unlimited YouTube', 'amount' => 10000, 'description' => 'Valid for 7 days'],
            ];
        } elseif ($slug === 'pln') {
            $products = [
                ['id' => 21, 'name' => 'Token PLN 20.000', 'amount' => 22000, 'description' => 'Estimasi 13.5 kWh'],
                ['id' => 22, 'name' => 'Token PLN 50.000', 'amount' => 52000, 'description' => 'Estimasi 33.5 kWh'],
                ['id' => 23, 'name' => 'Token PLN 100.000', 'amount' => 102000, 'description' => 'Estimasi 67.5 kWh'],
            ];
        } else {
            // General Fallback
            $products = [
                ['id' => 99, 'name' => 'Demo Product', 'amount' => 10000, 'description' => 'For testing'],
            ];
        }

        return view('store.category', compact('categoryName', 'slug', 'products'));
    }

    public function purchase(Request $request, PaymentService $paymentService)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'identifier' => 'required|string', // phone number or ID
            'product_name' => 'required|string',
        ]);

        // Find or create a system merchant for these transactions
        $merchant = Merchant::firstOrCreate(
            ['name' => 'LitePay Digital Services'],
            ['user_id' => User::first()->id ?? 1, 'api_key' => Str::random(10), 'api_secret' => Str::random(10), 'status' => 'active']
        );

        // Create Transaction using PaymentService
        $transaction = $paymentService->createTransaction($merchant, [
            'invoice_id' => 'INV-' . strtoupper(Str::random(10)),
            'amount' => $request->amount,
            'product_name' => $request->product_name,
            'payment_channel' => 'auto_detect',
            'user_id' => \Auth::check() ? \Auth::id() : null, // Attach user ID if logged in
        ]);

        return redirect()->route('checkout.show', $transaction->reference_id);
    }
}
