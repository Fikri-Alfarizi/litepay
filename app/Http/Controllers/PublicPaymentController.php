<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Services\PaymentService;

class PublicPaymentController extends Controller
{
    public function show($reference_id)
    {
        $transaction = Transaction::where('reference_id', $reference_id)->firstOrFail();
        
        if ($transaction->status !== 'PENDING') {
            return view('payment.finished', compact('transaction'));
        }

        return view('payment.checkout', compact('transaction'));
    }

    public function process($reference_id, Request $request, PaymentService $service)
    {
        $transaction = Transaction::where('reference_id', $reference_id)->firstOrFail();
        
        // Simulate processing...
        $status = $request->action === 'pay' ? 'SUCCESS' : 'FAILED';
        
        $service->updateStatus($transaction, $status);

        return redirect()->route('payment.pay', $reference_id);
    }
}
