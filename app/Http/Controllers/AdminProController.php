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

    public function transactions(Request $request)
    {
        $query = Transaction::with(['merchant', 'customer']);

        // Search
        if ($request->has('search') && $request->search != '') {
             $query->where(function($q) use ($request) {
                 $q->where('reference_id', 'like', '%' . $request->search . '%')
                   ->orWhere('invoice_id', 'like', '%' . $request->search . '%')
                   ->orWhereHas('merchant', function($mq) use ($request) {
                       $mq->where('name', 'like', '%' . $request->search . '%');
                   });
             });
        }

        // Filter Status
        if ($request->has('status') && $request->status != 'All Statuses' && $request->status != '') {
            $query->where('status', strtoupper($request->status));
        }
        
        // Filter Payment Channel
        if ($request->has('channel') && $request->channel != 'All Methods' && $request->channel != '') {
             // Mapping visual names to DB values if needed, for now exact match or simple mapping
             // 'Virtual Account' -> 'virtual_account' etc.
             $channelMap = [
                 'Virtual Account' => 'virtual_account',
                 'Credit Card' => 'credit_card',
                 'Qris' => 'qris' // assuming db value is 'qris' or 'QRIS'
             ];
             $dbChannel = $channelMap[$request->channel] ?? $request->channel;
             $query->where('payment_channel', $dbChannel);
        }

        $transactions = $query->latest()->paginate(10);

        // Stats calculation
        $pendingCount = Transaction::where('status', 'PENDING')->count();
        $successCount = Transaction::where('status', 'SUCCESS')->count();
        $totalCount = Transaction::count();
        $successRate = $totalCount > 0 ? round(($successCount / $totalCount) * 100, 1) : 0;
        $failedToday = Transaction::where('status', 'FAILED')->whereDate('created_at', now())->count();

        return view('admin_pro.transactions', compact('transactions', 'pendingCount', 'successRate', 'failedToday'));
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

    public function merchants(Request $request)
    {
        $query = \App\Models\Merchant::with('user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('email', 'like', "%{$search}%");
                  });
        }

        $merchants = $query->paginate(10);

        // Process data for presentation (volume, growth)
        foreach ($merchants as $merchant) {
            $currentMonthVolume = $merchant->transactions()
                ->where('status', 'SUCCESS')
                ->whereMonth('created_at', now()->month)
                ->sum('amount');
            
            $lastMonthVolume = $merchant->transactions()
                ->where('status', 'SUCCESS')
                ->whereMonth('created_at', now()->subMonth()->month)
                ->sum('amount');

            $merchant->volume = $currentMonthVolume;
            
            // Avoid division by zero
            if ($lastMonthVolume > 0) {
                $merchant->growth = (($currentMonthVolume - $lastMonthVolume) / $lastMonthVolume) * 100;
            } else {
                $merchant->growth = $currentMonthVolume > 0 ? 100 : 0;
            }
            
            $merchant->last_active = $merchant->transactions()->latest()->first()->created_at ?? $merchant->updated_at;
        }

        return view('admin_pro.merchants', compact('merchants'));
    }

    public function balance()
    {
        // Calculate Active Balance (Total Success)
        $activeBalance = Transaction::where('status', 'SUCCESS')->sum('total_amount');

        // Calculate Pending Settlement (Total Pending)
        $pendingSettlement = Transaction::where('status', 'PENDING')->sum('total_amount');

        // On Hold (Dummy for now, could be disputes etc.)
        $onHold = 0;

        // Mutation History (Recent 10 Success Transactions) report as "Settlement"
        // In a real system, there would be a separate Ledger/Mutations table.
        // using Transactions as a proxy for "Incoming Payouts"
        $mutations = Transaction::where('status', 'SUCCESS')
            ->latest()
            ->take(10)
            ->get();

        return view('admin_pro.balance', compact('activeBalance', 'pendingSettlement', 'onHold', 'mutations'));
    }

    public function promo()
    {
        $promos = \App\Models\Promo::latest()->get();
        return view('admin_pro.promo', compact('promos'));
    }

    public function settlements()
    {
        $pendingSettlements = \App\Models\Settlement::with('merchant')->where('status', 'pending')->latest()->get();
        
        $totalPending = $pendingSettlements->sum('amount');
        
        $processedToday = \App\Models\Settlement::where('status', 'processed')
            ->whereDate('processed_at', now())
            ->sum('amount');

        return view('admin_pro.settlements', compact('pendingSettlements', 'totalPending', 'processedToday'));
    }

    public function risk()
    {
        $fraudAlerts = \App\Models\FraudAlert::with('transaction')->latest()->take(20)->get();

        // Stats for Chart (Mocking real-time by minute for last 30 mins)
        // In real app, group by minute.
        $chartData = [];
        for ($i = 0; $i < 30; $i++) {
            $chartData[] = rand(5, 50); // Mock data for visual 'live' feel as requested
        }

        // Risk Distribution
        $total = \App\Models\FraudAlert::count();
        if ($total > 0) {
            $low = \App\Models\FraudAlert::where('risk_score', '<', 50)->count();
            $medium = \App\Models\FraudAlert::whereBetween('risk_score', [50, 79])->count();
            $high = \App\Models\FraudAlert::where('risk_score', '>=', 80)->count();
            
            $lowPct = round(($low / $total) * 100);
            $medPct = round(($medium / $total) * 100);
            $highPct = round(($high / $total) * 100);
        } else {
            $lowPct = 85; $medPct = 12; $highPct = 3; // Defaults for empty state
        }

        return view('admin_pro.risk', compact('fraudAlerts', 'chartData', 'lowPct', 'medPct', 'highPct'));
    }
}
