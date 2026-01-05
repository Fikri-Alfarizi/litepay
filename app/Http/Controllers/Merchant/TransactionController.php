<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            abort(403, 'User is not a merchant.');
        }

        $transactions = $merchant->transactions()->latest()->paginate(10);

        return view('merchant.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $user = Auth::user();

        if (!$user->merchant || $transaction->merchant_id !== $user->merchant->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('merchant.transactions.show', compact('transaction'));
    }
}
