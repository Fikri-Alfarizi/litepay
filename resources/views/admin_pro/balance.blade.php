@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">Balance & Settlements</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Manage your funds and payouts.</p>
        </div>
        <div class="flex space-x-2">
             <a href="{{ route('admin_pro.balance.top_up') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg shadow-sm transition flex items-center space-x-2 text-xs font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Top Up</span>
            </a>
             <a href="{{ route('admin_pro.balance.withdraw') }}" class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 px-3 py-2 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 text-xs font-medium">
                Withdraw
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <!-- Main Balance Card -->
        <div class="col-span-2 bg-gradient-to-r from-indigo-800 to-indigo-600 rounded-lg p-5 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-1/2 bg-white opacity-5 transform skew-x-12"></div>
            <div class="relative z-10">
                <p class="text-indigo-200 text-xs font-semibold uppercase tracking-wider">Active Balance</p>
                <h2 class="text-3xl font-bold mt-1">Rp {{ number_format($activeBalance, 0, ',', '.') }}</h2>
                <div class="mt-4 flex space-x-6">
                    <div>
                        <p class="text-indigo-200 text-[10px] text-opacity-80">On Hold</p>
                        <p class="font-bold text-sm">Rp {{ number_format($onHold, 0, ',', '.') }}</p>
                    </div>
                     <div>
                        <p class="text-indigo-200 text-[10px] text-opacity-80">Pending Settlement</p>
                         <p class="font-bold text-sm">Rp {{ number_format($pendingSettlement, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bank Account Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-sm text-gray-700 dark:text-gray-200 mb-2">Primary Bank Account</h3>
                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg mb-2">
                    <div class="flex justify-between items-start">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1200px-Bank_Central_Asia.svg.png" class="h-6 object-contain filter dark:brightness-200">
                        <span class="bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 text-[10px] font-bold px-1.5 py-0.5 rounded">Verified</span>
                    </div>
                    <p class="font-mono text-gray-600 dark:text-gray-300 mt-2 font-bold text-base">**** **** 4592</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">PT LitePay Indonesia</p>
                </div>
            </div>
            <button class="text-indigo-600 dark:text-indigo-400 text-xs font-medium hover:text-indigo-800 dark:hover:text-indigo-300 text-left">Manage Bank Accounts &rarr;</button>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <h3 class="font-bold text-sm text-gray-700 dark:text-gray-200">Mutation History</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                        <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reference</th>
                        <th class="px-4 py-2 text-right text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($mutations as $mutation)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                {{ $mutation->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <span class="block text-xs font-bold text-gray-800 dark:text-gray-100">Settlement from TRX</span>
                                <span class="text-[10px] text-gray-500 dark:text-gray-400">Merchant Payment</span>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-xs font-mono text-gray-500 dark:text-gray-400">
                                {{ $mutation->reference_id }}
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-right">
                                <span class="text-xs font-bold text-green-600 dark:text-green-400">
                                    + Rp {{ number_format($mutation->amount, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                         <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-500">No mutations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
