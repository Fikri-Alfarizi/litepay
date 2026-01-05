@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Settlements</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Manage merchant payouts and fund transfers.</p>
        </div>
        <div class="flex space-x-3">
             <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow transition flex items-center space-x-2 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span>Export CSV</span>
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow border border-gray-100 dark:border-gray-700">
            <h3 class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase">Pending Payouts</h3>
            <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-2">Rp 450.5M</p>
            <p class="text-xs text-gray-400 mt-1">12 requests waiting</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow border border-gray-100 dark:border-gray-700">
             <h3 class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase">Processed Today</h3>
            <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-2">Rp 1.2B</p>
            <p class="text-xs text-green-500 mt-1">Successfully transferred</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow border border-gray-100 dark:border-gray-700">
             <h3 class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase">Next Batch</h3>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">14:00 WIB</p>
            <p class="text-xs text-gray-400 mt-1">Auto-scheduled</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <h3 class="font-bold text-gray-700 dark:text-gray-200">Pending Withdrawal Requests</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Merchant</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bank Details</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Requested</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @for ($i = 0; $i < 5; $i++)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-0">
                                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">Merchant Partner #{{ $i+1 }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">TAX ID: 829.123.{{ rand(100, 999) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="block text-sm font-bold text-gray-800 dark:text-gray-100">{{ ['BCA', 'Mandiri', 'BRI', 'BNI'][$i % 4] }}</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400 font-mono">{{ rand(1000000000, 9999999999) }}</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400">A/N PT Merchant Sejahtera</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format(rand(10000000, 50000000), 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ now()->subHours($i)->format('H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="bg-green-600 text-white px-3 py-1 rounded shadow hover:bg-green-700 text-xs mr-2">Approve</button>
                                <button class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-xs">Reject</button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
