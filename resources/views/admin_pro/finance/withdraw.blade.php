@extends('layouts.admin_pro')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6 text-sm text-gray-500">
             <a href="{{ route('admin_pro.balance') }}" class="hover:text-indigo-600 hover:underline">Balance</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="font-medium text-gray-800">Withdraw</span>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-2">Withdraw Funds</h1>
        <p class="text-gray-500 mb-8">Transfer money to your registered bank account.</p>

        <div x-data="{ amount: 0, fee: 6500 }" class="space-y-6">
            
            <!-- Bank Account -->
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-indigo-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Destination Account</p>
                        <p class="font-bold text-gray-800 text-lg">BCA - 1234567890</p>
                        <p class="text-sm text-gray-600">A/N PT LitePay Indonesia</p>
                    </div>
                    <button class="text-indigo-600 text-sm font-medium hover:underline">Change</button>
                </div>
            </div>

            <!-- Amount Input -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between mb-2">
                     <label class="block text-sm font-medium text-gray-700">Withdrawal Amount</label>
                     <span class="text-sm text-gray-500">Available: <span class="font-bold text-gray-800">Rp 124.500.000</span></span>
                </div>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                    </div>
                    <input type="number" x-model="amount" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-12 py-3 sm:text-lg font-bold border-gray-300 rounded-lg placeholder-gray-300" placeholder="0">
                </div>
                 <div class="mt-4 bg-gray-50 p-4 rounded-lg space-y-2">
                     <div class="flex justify-between text-sm">
                         <span class="text-gray-500">Withdrawal Amount</span>
                         <span class="font-medium" x-text="'Rp ' + parseInt(amount || 0).toLocaleString('id-ID')">Rp 0</span>
                     </div>
                     <div class="flex justify-between text-sm">
                         <span class="text-gray-500">Admin Fee</span>
                         <span class="font-medium text-red-500" x-text="'- Rp ' + fee.toLocaleString('id-ID')">- Rp 6.500</span>
                     </div>
                     <div class="border-t border-gray-200 pt-2 flex justify-between text-base font-bold text-gray-800">
                         <span>Total Received</span>
                         <span x-text="'Rp ' + (amount > fee ? (amount - fee).toLocaleString('id-ID') : 0)">Rp 0</span>
                     </div>
                 </div>
            </div>

            <!-- Security Pin Mock -->
            <div class="bg-white rounded-xl shadow p-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm with 6-digit PIN</label>
                <div class="flex space-x-4">
                     <input type="password" maxlength="6" class="flex-1 text-center font-bold tracking-widest text-2xl border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-2" placeholder="••••••">
                </div>
            </div>

            <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg transition" :disabled="amount < 15000" :class="{'opacity-50 cursor-not-allowed': amount < 15000}">
                Confirm Withdrawal
            </button>
        </div>
    </div>
@endsection
