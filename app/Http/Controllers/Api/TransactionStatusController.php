<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionStatusController extends Controller
{
    public function check($invoice_id)
    {
        // Simple public check or authenticated? Usage implies public status check or merchant check.
        // For security, usually requires auth, but for "Lite" maybe just by Invoice ID if unique?
        // Invoice ID is unique per merchant, not globally unique in schema (wait, schema said unique() on invoice_id?). 
        // Migration: $table->string('invoice_id')->unique(); -> Yes, globally unique in this system design.

        $transaction = \App\Models\Transaction::where('invoice_id', $invoice_id)->first();

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'invoice_id' => $transaction->invoice_id,
                'status' => $transaction->status,
                'amount' => $transaction->amount,
                'paid_at' => $transaction->paid_at,
            ]
        ]);
    }
}
