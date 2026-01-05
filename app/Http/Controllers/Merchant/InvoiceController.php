<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\PaymentService;

class InvoiceController extends Controller
{
    public function index()
    {
        $merchant = Auth::user()->merchant;
        if (!$merchant)
            abort(403);

        $invoices = $merchant->transactions()->latest()->paginate(10);
        return view('merchant.invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('merchant.invoices.create');
    }

    public function store(Request $request, \App\Services\PaymentService $paymentService)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'customer_email' => 'nullable|email',
            'description' => 'nullable|string',
        ]);

        $merchant = Auth::user()->merchant;
        if (!$merchant)
            abort(403);

        $invoiceId = 'INV-' . strtoupper(Str::random(10));

        // Use upstream PaymentService to create transaction
        $transaction = $paymentService->createTransaction($merchant, [
            'invoice_id' => $invoiceId,
            'amount' => $request->amount,
            'payment_channel' => 'auto_detect', // Or 'manual_link'
        ]);

        // Note: The upstream service generates its own reference_id (e.g. random 12 chars)
        // We can redirect to the show page using that transaction model.

        return redirect()->route('merchant.invoices.show', $transaction)->with('success', 'Invoice created successfully.');
    }

    public function show(Transaction $transaction)
    {
        $user = Auth::user();
        if (!$user->merchant || $transaction->merchant_id !== $user->merchant->id) {
            abort(403);
        }

        return view('merchant.invoices.show', compact('transaction'));
    }
}
