<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class HistoryController extends Controller
{
    public function index()
    {
        $transactions = Auth::user()->customerTransactions()
            ->with(['merchant'])
            ->latest()
            ->paginate(10);

        return view('customer.history.index', compact('transactions'));
    }
}
