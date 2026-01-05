<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = \App\Models\Transaction::with('merchant')->latest()->paginate(20);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function detail(\App\Models\Transaction $transaction)
    {
        $transaction->load('merchant', 'website_callback_logs'); // Assuming 'website_callback_logs' relationship name
        return view('admin.transactions.detail', compact('transaction'));
    }
    
    // Helper to simulate payment status change (Admin override)
    public function updateStatus(\App\Models\Transaction $transaction, \Illuminate\Http\Request $request, \App\Services\PaymentService $service)
    {
        $request->validate(['status' => 'required|in:SUCCESS,FAILED']);
        $service->updateStatus($transaction, $request->status);
        return back()->with('success', 'Transaction updated');
    }
}
