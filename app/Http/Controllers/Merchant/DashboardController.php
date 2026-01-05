<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $merchant = Auth::user()->merchant;
        if (!$merchant) {
            return redirect()->route('login')->with('error', 'You are not a merchant.');
        }

        $totalTransactions = $merchant->transactions()->count();
        $totalRevenue = $merchant->transactions()->where('status', 'paid')->sum('amount');
        $recentTransactions = $merchant->transactions()->latest()->take(5)->get();

        return view('merchant.dashboard.index', compact('totalTransactions', 'totalRevenue', 'recentTransactions'));
    }
}
