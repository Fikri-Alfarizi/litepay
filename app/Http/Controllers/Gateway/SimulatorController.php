<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class SimulatorController extends Controller
{
    /**
     * Show a mock "Customer Bank App" scan page
     */
    public function show($reference)
    {
        $transaction = Transaction::where('reference_id', $reference)->firstOrFail();
        
        if ($transaction->status !== 'PENDING') {
            return "Transaction already processed: " . $transaction->status;
        }

        return view('gateway.simulator.scan', compact('transaction'));
    }

    /**
     * Handle the "Pay" button inside the simulator
     */
    public function pay(Request $request, $reference, PaymentService $paymentService)
    {
        $transaction = Transaction::where('reference_id', $reference)->firstOrFail();

        if ($transaction->status !== 'PENDING') {
            return response()->json(['message' => 'Already processed'], 400);
        }

        // Validate PIN
        // In this simulation, we access the Merchant DB (OrderPayment) to find the User
        // This simulates the "Bank App" knowing the user
        $orderPayment = \App\Models\OrderPayment::where('invoice_id', $transaction->invoice_id)->first();
        
        if (!$orderPayment) {
             return response()->json(['message' => 'Order not found for this transaction'], 404);
        }

        $user = $orderPayment->order->user;

        if (!$user) {
             return response()->json(['message' => 'User not found'], 404);
        }

        if (!\Hash::check($request->pin, $user->pin)) {
            return response()->json(['message' => 'Incorrect PIN'], 400);
        }

        // Simulate Gateway update -> triggers callback to Merchant
        $paymentService->updateStatus($transaction, 'SUCCESS');

        return response()->json(['message' => 'Gateway processed payment successfully']);
    }
}
