<?php

namespace App\Http\Controllers;

use App\Models\CallbackLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    public function handle(Request $request)
    {
        // Log incoming request
        Log::info('Callback received', $request->all());

        $invoiceId = $request->input('invoice_id');
        $status = $request->input('status');

        // 1. Merchant DB: Record Callback
        \App\Models\PaymentCallback::create([
            'invoice_id' => $invoiceId,
            'status' => $status,
            'payload' => json_encode($request->all()),
            'received_at' => now(),
        ]);

        // 2. Merchant DB: Update OrderPayment & Order
        $orderPayment = \App\Models\OrderPayment::where('invoice_id', $invoiceId)->first();
        if ($orderPayment) {
            $orderPayment->update([
                'payment_status' => $status,
                'paid_at' => $status === 'paid' ? now() : null,
            ]);

            if ($status === 'paid') {
                $orderPayment->order->update(['status' => 'PAID']);
            }
        }

        return response()->json(['message' => 'Callback received and processed by Merchant']);
    }
}
