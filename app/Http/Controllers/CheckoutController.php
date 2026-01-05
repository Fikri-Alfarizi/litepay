<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(string $reference)
    {
        $transaction = Transaction::where('reference_id', $reference)
            ->where('status', 'pending')
            ->firstOrFail();

        return view('checkout.show', compact('transaction'));
    }

    public function process(Request $request, string $reference)
    {
        $transaction = Transaction::where('reference_id', $reference)
            ->where('status', 'pending')
            ->firstOrFail();

        // Simulate payment processing
        // In reality, this would redirect to a real payment gateway (Friend's part)
        // For this task, we will just simulate a successful payment locally or redirect to a success page

        $transaction->update([
            'status' => 'paid',
            'paid_at' => now(),
            'payment_channel' => 'simulation_channel'
        ]);

        // Trigger callback notification (mock)
        // ...

        return redirect()->route('checkout.success', $reference);
    }

    public function success(string $reference)
    {
        $transaction = Transaction::where('reference_id', $reference)->firstOrFail();

        return view('checkout.success', compact('transaction'));
    }
}
