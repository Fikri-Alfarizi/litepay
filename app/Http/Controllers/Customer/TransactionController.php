<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function showByInvoice($invoice_id)
    {
        // Find transaction by Invoice ID first (without user check initially to handle legacy data)
        $transaction = Transaction::where('invoice_id', $invoice_id)->first();

        if (!$transaction) {
            return redirect()->route('customer.inbox')->with('error', 'Transaction not found.');
        }

        // Security Check: Ensure this transaction belongs to the authenticated user
        if ($transaction->user_id && $transaction->user_id != Auth::id()) {
            abort(403, 'Unauthorized access to this transaction.');
        }

        // Fallback for legacy data: If user_id is null, check Order ownership
        if (is_null($transaction->user_id)) {
            // Check if there is an Order for this invoice belonging to this user
            $hasOrder = \App\Models\Order::where('user_id', Auth::id())
                ->whereHas('payment', function($q) use ($invoice_id) {
                    $q->where('invoice_id', $invoice_id);
                })
                ->exists();
            
            if (!$hasOrder) {
                 abort(403, 'Unauthorized access to this transaction.');
            }
            
            // Optional: Backfill user_id to fix it for next time
            $transaction->update(['user_id' => Auth::id()]);
        }

        return redirect()->route('customer.transaction.show', $transaction->reference_id);
    }
    
    public function show($reference_id)
    {
        $transaction = Transaction::where('reference_id', $reference_id)->firstOrFail();

        // Security Check
        if ($transaction->user_id && $transaction->user_id != Auth::id()) {
             abort(403);
        }
        
        // Legacy Check
        if (is_null($transaction->user_id)) {
             $hasOrder = \App\Models\Order::where('user_id', Auth::id())
                ->whereHas('payment', function($q) use ($transaction) {
                    $q->where('invoice_id', $transaction->invoice_id);
                })
                ->exists();
                
             if (!$hasOrder) abort(403);
             $transaction->update(['user_id' => Auth::id()]);
        }

        // Redirect Pending Transactions to Checkout
        if ($transaction->status === 'PENDING') {
            return redirect()->route('checkout.show', $transaction->reference_id);
        }

        return view('customer.transaction.detail', compact('transaction'));
    }
}
