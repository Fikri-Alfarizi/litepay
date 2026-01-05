<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTransactions = \App\Models\Transaction::count();
        $success = \App\Models\Transaction::where('status', 'SUCCESS')->count();
        $failed = \App\Models\Transaction::where('status', 'FAILED')->count();
        $pending = \App\Models\Transaction::where('status', 'PENDING')->count();
        $totalAmount = \App\Models\Transaction::where('status', 'SUCCESS')->sum('amount');

        return view('admin.dashboard', compact('totalTransactions', 'success', 'failed', 'pending', 'totalAmount'));
    }
}
