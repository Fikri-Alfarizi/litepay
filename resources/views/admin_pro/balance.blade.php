@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Balance & Settlements</h1>
            <p class="text-gray-500 mt-1">Manage your funds and payouts.</p>
        </div>
        <div class="flex space-x-3">
             <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow transition flex items-center space-x-2 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Top Up</span>
            </button>
             <button class="bg-white border border-gray-300 text-gray-700 px-5 py-2.5 rounded-lg shadow-sm hover:bg-gray-50 font-medium">
                Withdraw
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Main Balance Card -->
        <div class="col-span-2 bg-gradient-to-r from-indigo-800 to-indigo-600 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-1/2 bg-white opacity-5 transform skew-x-12"></div>
            <div class="relative z-10">
                <p class="text-indigo-200 text-sm font-semibold uppercase tracking-wider">Active Balance</p>
                <h2 class="text-4xl font-bold mt-2">Rp 124.500.000</h2>
                <div class="mt-6 flex space-x-6">
                    <div>
                        <p class="text-indigo-200 text-xs text-opacity-80">On Hold</p>
                        <p class="font-bold">Rp 2.300.000</p>
                    </div>
                     <div>
                        <p class="text-indigo-200 text-xs text-opacity-80">Pending Settlement</p>
                         <p class="font-bold">Rp 15.420.000</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bank Account Card -->
        <div class="bg-white rounded-2xl p-6 shadow border border-gray-100 flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-gray-700 mb-4">Primary Bank Account</h3>
                <div class="bg-gray-50 p-4 rounded-lg mb-2">
                    <div class="flex justify-between items-start">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1200px-Bank_Central_Asia.svg.png" class="h-8 object-contain">
                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">Verified</span>
                    </div>
                    <p class="font-mono text-gray-600 mt-3 font-bold text-lg">**** **** 4592</p>
                    <p class="text-sm text-gray-500">PT LitePay Indonesia</p>
                </div>
            </div>
            <button class="text-indigo-600 text-sm font-medium hover:text-indigo-800 text-left">Manage Bank Accounts &rarr;</button>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="font-bold text-gray-700">Mutation History</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Reference</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @for ($i = 0; $i < 6; $i++)
                        @php $isCredit = rand(0, 1) == 1; @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ now()->subDays($i)->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="block text-sm font-bold text-gray-800">{{ $isCredit ? 'Settlement from TRX' : 'Withdrawal Fee' }}</span>
                                <span class="text-xs text-gray-400">Merchant Payment</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-500">
                                REF-{{ rand(100000, 999999) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="text-sm font-bold {{ $isCredit ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $isCredit ? '+' : '-' }} Rp {{ number_format(rand(50000, 500000), 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
