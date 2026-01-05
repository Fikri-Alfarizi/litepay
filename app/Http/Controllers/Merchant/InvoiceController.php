<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class InvoiceController extends Controller
{
    public function index()
    {
        $merchant = Auth::user()->merchant;
        $invoices = $merchant->transactions()->latest()->paginate(10); // Treating transactions as "Invoices" for list
        return view('merchant.invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('merchant.invoices.create');
    }

    public function store(\Illuminate\Http\Request $request, \App\Services\PaymentService $paymentService)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            // Invoice ID usually auto-generated or manual? Let's say manual or auto.
            // Simplified: User inputs amount, we generate invoice/transaction.
        ]);
        
        $merchant = Auth::user()->merchant;
        // Generate a random invoice ID for UI created invoices
        $invoiceId = 'INV-' . time(); 

        $paymentService->createTransaction($merchant, [
            'invoice_id' => $invoiceId,
            'amount' => $request->amount,
            'payment_channel' => 'manual_link'
        ]);

        return redirect()->route('merchant.invoices.index')->with('success', 'Invoice created');
    }

    public function detail(\App\Models\Transaction $invoice) // binding to transaction model
    {
        // Authorization check
        if ($invoice->merchant_id !== Auth::user()->merchant->id) {
            abort(403);
        }
        return view('merchant.invoices.detail', compact('invoice'));
    }
}
