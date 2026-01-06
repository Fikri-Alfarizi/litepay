<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\CallbackLog; // Assuming this model exists or we'll create it/ignore for now
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminProController extends Controller
{
    public function dashboard()
    {
        // Calculate Stats
        $today = Carbon::today();
        
        $stats = [
            'transactions_today' => Transaction::whereDate('created_at', $today)->count(),
            'transaction_value_today' => Transaction::whereDate('created_at', $today)->where('status', 'SUCCESS')->sum('amount'),
            'active_balance' => Transaction::where('status', 'SUCCESS')->sum('total_amount'), // Total funds held
            'success_rate' => 0,
            'pending_count' => Transaction::where('status', 'PENDING')->count(),
        ];

        // Success Rate
        $totalTx = Transaction::count();
        $successTx = Transaction::where('status', 'SUCCESS')->count();
        $stats['success_rate'] = $totalTx > 0 ? round(($successTx / $totalTx) * 100, 1) : 0;

        // Recent Transactions
        $recentTransactions = Transaction::with(['merchant', 'customer'])->latest()->take(5)->get();

        // Chart Data (Last 7 Days Revenue)
        $chartData = [
            'labels' => [],
            'data' => []
        ];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData['labels'][] = $date->format('D'); // Mon, Tue...
            $chartData['data'][] = Transaction::whereDate('created_at', $date)
                                      ->where('status', 'SUCCESS')
                                      ->sum('amount'); // or total_amount/fee
        }

        return view('admin_pro.dashboard', compact('stats', 'recentTransactions', 'chartData'));
    }

    public function transactions()
    {
        $transactions = Transaction::with(['merchant', 'customer'])->latest()->paginate(10);
        return view('admin_pro.transactions', compact('transactions'));
    }

    public function callbacks()
    {
        $callbacks = CallbackLog::with(['transaction.merchant'])->latest()->paginate(15);
        return view('admin_pro.callbacks', compact('callbacks'));
    }

    public function api()
    {
        $user = auth()->user();
        if (!$user) {
            // Should be handled by middleware, but safely check
            return redirect()->route('login');
        }

        // Get or Create Merchant Record for this user
        // Assuming Admin is also a generic merchant for testing
        $merchant = \App\Models\Merchant::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name . "'s Store",
                'status' => 'active',
                'api_key' => \Illuminate\Support\Str::random(32),
                'api_secret' => \Illuminate\Support\Str::random(32),
                'callback_url' => 'https://example.com/callback'
            ]
        );

        return view('admin_pro.api_management', compact('merchant'));
    }

    public function regenerateKey(Request $request)
    {
        $user = auth()->user();
        $merchant = \App\Models\Merchant::where('user_id', $user->id)->firstOrFail();

        $merchant->update([
            'api_key' => 'sk_live_' . \Illuminate\Support\Str::random(32)
        ]);

        return redirect()->back()->with('success', 'API Key Regenerated Successfully');
    }

    public function settings()
    {
        return view('admin_pro.settings');
    }
}
