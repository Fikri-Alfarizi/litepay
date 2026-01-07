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
    public function pay($reference, PaymentService $paymentService)
    {
        $transaction = Transaction::where('reference_id', $reference)->firstOrFail();

        if ($transaction->status !== 'PENDING') {
            return response()->json(['message' => 'Already processed'], 400);
        }

        // Simulate Gateway update -> triggers callback to Merchant
        $paymentService->updateStatus($transaction, 'SUCCESS');

        return response()->json(['message' => 'Gateway processed payment successfully']);
    }
}
