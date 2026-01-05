<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMerchants = Merchant::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::where('status', 'paid')->sum('amount');

        $recentTransactions = Transaction::with('merchant.user')->latest()->take(5)->get();

        return view('admin.dashboard.index', compact('totalMerchants', 'totalTransactions', 'totalRevenue', 'recentTransactions'));
    }
}
