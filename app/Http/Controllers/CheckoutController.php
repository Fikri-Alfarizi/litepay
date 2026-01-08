<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show($reference)
    {
        $transaction = Transaction::where('reference_id', $reference)->firstOrFail();
        
        // If already paid, redirect to success
        if ($transaction->status === 'SUCCESS') {
            return redirect()->route('checkout.success', $reference);
        }

        $linkedAccounts = auth()->check() ? auth()->user()->linkedAccounts : collect([]);

        return view('checkout.show', compact('transaction', 'linkedAccounts'));
    }

    public function success($reference)
    {
        $transaction = Transaction::where('reference_id', $reference)->firstOrFail();

        if ($transaction->status !== 'SUCCESS') {
            return redirect()->route('checkout.show', $reference);
        }

        return view('checkout.success', compact('transaction'));
    }

    public function checkStatus($reference)
    {
        $transaction = Transaction::where('reference_id', $reference)->firstOrFail();
        
        return response()->json([
            'status' => $transaction->status,
            'redirect_url' => $transaction->status === 'SUCCESS' ? route('checkout.show', $reference) : null
        ]);
    }

    public function simulatePay(Request $request, $reference, PaymentService $paymentService)
    {
        $transaction = Transaction::where('reference_id', $reference)->firstOrFail();
        
        if ($transaction->status !== 'PENDING') {
            return response()->json(['message' => 'Transaction already processed'], 400);
        }

        $paymentService->updateStatus($transaction, 'SUCCESS');

        return response()->json(['message' => 'Payment Successful']);
    }

    public function pay(Request $request, $reference, PaymentService $paymentService)
    {
        $transaction = Transaction::where('reference_id', $reference)->firstOrFail();
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if ($transaction->status !== 'PENDING') {
            return response()->json(['message' => 'Transaction already processed'], 400);
        }

        // Validate PIN
        if (!\Hash::check($request->pin, $user->pin)) {
            return response()->json(['message' => 'Incorrect PIN'], 400);
        }

        $paymentMethod = $request->payment_method;

        // Atomic transaction
        try {
            \DB::transaction(function () use ($user, $transaction, $paymentService, $paymentMethod) {
                
                if ($paymentMethod === 'balance') {
                    if ($user->balance < $transaction->total_amount) {
                        throw new \Exception('Insufficient balance');
                    }
                    $user->decrement('balance', $transaction->total_amount);
                    $transaction->update(['payment_channel' => 'litepay_balance']);
                } else {
                    // Linked Account (Simulated)
                    // In real world, we would call API to charge the linked account here
                    $transaction->update(['payment_channel' => $paymentMethod]);
                }

                $paymentService->updateStatus($transaction, 'SUCCESS');
            });
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json(['message' => 'Payment Successful']);
    }
    public function cancel($reference, PaymentService $paymentService)
    {
        $transaction = Transaction::where('reference_id', $reference)->firstOrFail();

        if ($transaction->status === 'PENDING') {
            $paymentService->updateStatus($transaction, 'FAILED');
        }

        return redirect()->route('store.index')->with('info', 'Transaction cancelled.');
    }
}
