<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Models\Merchant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ConsumerTransactionController extends Controller
{
    public function topUp()
    {
        return view('transaction.topup');
    }

    public function processTopUp(Request $request, PaymentService $paymentService)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $amount = $request->amount;
        // In a real app, we'd have a specific "System Merchant" for top-ups.
        // For now, we'll grab the first merchant or fail if none.
        $merchant = Merchant::first();

        if (!$merchant) {
            return back()->with('error', 'System configuration error: No merchant available to process top-up.');
        }

        $transaction = $paymentService->createTransaction($merchant, [
            'invoice_id' => 'TOPUP-' . strtoupper(Str::random(8)),
            'amount' => $amount,
            'product_name' => 'Top Up Balance',
            'payment_channel' => 'all', // Let user choose at checkout
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('checkout.show', $transaction->reference_id);
    }
}
