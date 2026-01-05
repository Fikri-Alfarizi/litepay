@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">Dashboard Overview</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Performance metrics for today.</p>
        </div>
        <div>
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg shadow-sm transition flex items-center space-x-2 text-xs font-medium">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Generate Report</span>
            </button>
        </div>
    </div>

    <!-- Compact Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <!-- Active Balance (New) -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 hover:shadow-md transition border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Active Balance</p>
                <div class="p-1.5 bg-blue-50 dark:bg-blue-900/30 rounded-full text-blue-600 dark:text-blue-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
            </div>
            <p class="text-lg font-bold text-gray-800 dark:text-gray-100">Rp 124.5M</p>
            <p class="text-[10px] text-gray-400 mt-1">Available for payout</p>
        </div>

        <!-- Revenue Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 hover:shadow-md transition border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Revenue</p>
                <div class="p-1.5 bg-indigo-50 dark:bg-indigo-900/30 rounded-full text-indigo-600 dark:text-indigo-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-lg font-bold text-gray-800 dark:text-gray-100">Rp 12.5M</p>
            <p class="text-[10px] text-green-600 mt-1 font-medium flex items-center">
                <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +12.5% vs last mo
            </p>
        </div>

        <!-- Transactions Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 hover:shadow-md transition border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Transactions</p>
                <div class="p-1.5 bg-emerald-50 dark:bg-emerald-900/30 rounded-full text-emerald-600 dark:text-emerald-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>
            <p class="text-lg font-bold text-gray-800 dark:text-gray-100">1,254</p>
            <p class="text-[10px] text-green-600 mt-1 font-medium flex items-center">
                <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +5.2% daily avg
            </p>
        </div>

        <!-- Merchants Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 hover:shadow-md transition border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Merchants</p>
                <div class="p-1.5 bg-orange-50 dark:bg-orange-900/30 rounded-full text-orange-600 dark:text-orange-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <p class="text-lg font-bold text-gray-800 dark:text-gray-100">48</p>
            <p class="text-[10px] text-yellow-600 mt-1 font-medium flex items-center">
                <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                +2 this week
            </p>
        </div>

        <!-- Callbacks Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 hover:shadow-md transition border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Failed Callbacks</p>
                <div class="p-1.5 bg-rose-50 dark:bg-rose-900/30 rounded-full text-rose-600 dark:text-rose-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <p class="text-lg font-bold text-gray-800 dark:text-gray-100">23</p>
             <p class="text-[10px] text-rose-600 mt-1 font-medium flex items-center">
                <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                -10% vs last wk
            </p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Main Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm">
            <h3 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-3">Revenue Analytics</h3>
            <div class="h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        
        <!-- Side List -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm">
            <h3 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-3">Recent Transactions</h3>
            <div class="space-y-3">
                @for ($i = 0; $i < 5; $i++)
                    <div class="flex items-center justify-between p-2.5 bg-gray-50 dark:bg-gray-700 rounded-md hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                        <div class="flex items-center space-x-3">
                            <div class="h-8 w-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xs">
                                {{ substr(['Tokopedia', 'Shopee', 'Lazada', 'Blibli', 'Bukalapak'][$i], 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-800 dark:text-gray-200">{{ ['Tokopedia', 'Shopee', 'Lazada', 'Blibli', 'Bukalapak'][$i] }}</p>
                                <p class="text-[10px] text-gray-500 dark:text-gray-400">{{ now()->subMinutes($i * 15)->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-gray-800 dark:text-gray-200">+Rp {{ rand(50, 500) }}.000</p>
                            <p class="text-[10px] text-green-500 font-medium">Success</p>
                        </div>
                    </div>
                @endfor
            </div>
            <button class="w-full mt-3 text-center text-indigo-600 dark:text-indigo-400 text-xs font-bold hover:text-indigo-800 dark:hover:text-indigo-300">View All Transactions</button>
        </div>
    </div>

    @push('scripts')
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Revenue (Millions)',
                    data: [12, 19, 3, 5, 2, 3, 10],
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 2,
                    pointRadius: 3,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        tickets: { font: { size: 10 } },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                         ticks: { font: { size: 10 } }
                    }
                }
            }
        });
    </script>
    @endpush
@endsection
