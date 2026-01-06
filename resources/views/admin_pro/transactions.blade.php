@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">Transactions</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Real-time monitoring of all payment flows.</p>
        </div>
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg shadow-sm transition flex items-center space-x-2 text-xs font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            <span>Export Report</span>
        </button>
    </div>

    <!-- Stats for Transactions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="bg-indigo-600 rounded-lg p-4 text-white shadow-md">
            <h3 class="text-indigo-200 text-xs font-semibold uppercase">Pending</h3>
            <p class="text-2xl font-bold mt-1">{{ number_format($pendingCount) }}</p>
            <div class="w-full bg-indigo-800 h-1 mt-3 rounded-full overflow-hidden">
                <div class="bg-indigo-300 h-1 w-3/4"></div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-gray-500 dark:text-gray-400 text-xs font-semibold uppercase">Success Rate</h3>
            <p class="text-2xl font-bold mt-1 text-green-600 dark:text-green-400">{{ $successRate }}%</p>
             <p class="text-[10px] text-gray-400 mt-0.5">Slightly higher than industry avg.</p>
        </div>
         <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-gray-500 dark:text-gray-400 text-xs font-semibold uppercase">Failed (Today)</h3>
            <p class="text-2xl font-bold mt-1 text-red-600 dark:text-red-400">{{ $failedToday }}</p>
             <p class="text-[10px] text-gray-400 mt-0.5">Mostly user cancellations.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        <!-- Advanced Filter Toolbar -->
         <form action="{{ route('admin_pro.transactions') }}" method="GET" class="p-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex flex-wrap gap-3 items-center">
             <select name="status" onchange="this.form.submit()" class="border border-gray-300 dark:border-gray-600 rounded-md text-xs px-2.5 py-1.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:border-indigo-500">
                 <option {{ request('status') == 'All Statuses' ? 'selected' : '' }}>All Statuses</option>
                 <option {{ request('status') == 'Success' ? 'selected' : '' }}>Success</option>
                 <option {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                 <option {{ request('status') == 'Failed' ? 'selected' : '' }}>Failed</option>
             </select>
             
              <select name="channel" onchange="this.form.submit()" class="border border-gray-300 dark:border-gray-600 rounded-md text-xs px-2.5 py-1.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:border-indigo-500">
                 <option {{ request('channel') == 'All Methods' ? 'selected' : '' }}>All Methods</option>
                 <option {{ request('channel') == 'Virtual Account' ? 'selected' : '' }}>Virtual Account</option>
                 <option {{ request('channel') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                 <option {{ request('channel') == 'Qris' ? 'selected' : '' }}>Qris</option>
             </select>

             <div class="flex-1 text-right">
                  <div class="relative inline-block w-56">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Ref ID..." class="pl-8 pr-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:ring-indigo-500 focus:border-indigo-500 w-full dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                    <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                 </div>
             </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ref ID</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Merchant/User</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-2.5 whitespace-nowrap">
                                <span class="font-mono text-[10px] text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded px-1.5 py-0.5">{{ $transaction->reference_id }}</span>
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                {{ $transaction->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap text-xs font-medium text-gray-900 dark:text-gray-100">
                                {{ $transaction->merchant->name ?? 'System' }}
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap">
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-100">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap">
                                @php $status = $transaction->status; @endphp
                                <span class="px-2 py-0.5 inline-flex text-[10px] leading-4 font-bold rounded-full 
                                    {{ $status==='SUCCESS' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : ($status==='PENDING' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300') }}">
                                    {{ $status }}
                                </span>
                            </td>
                             <td class="px-4 py-2.5 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                <a href="{{ route('checkout.show', $transaction->reference_id) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200 font-medium">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">No transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
         <!-- Pagination -->
        <div class="bg-white dark:bg-gray-800 px-4 py-2 border-t border-gray-200 dark:border-gray-700 sm:px-4">
             {{ $transactions->withQueryString()->links() }}
        </div>
    </div>
@endsection
