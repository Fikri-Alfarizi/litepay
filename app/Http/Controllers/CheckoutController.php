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

        return view('checkout.show', compact('transaction'));
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
}
