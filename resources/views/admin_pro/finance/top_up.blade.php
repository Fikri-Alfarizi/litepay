@extends('layouts.admin_pro')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6 text-sm text-gray-500">
            <a href="{{ route('admin_pro.balance') }}" class="hover:text-indigo-600 hover:underline">Balance</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="font-medium text-gray-800">Top Up Funds</span>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-2">Top Up Balance</h1>
        <p class="text-gray-500 mb-8">Add funds to your merchant wallet instantly.</p>

        <div x-data="{ method: 'va', amount: 0 }" class="space-y-6">
            <!-- Amount Input -->
            <div class="bg-white rounded-xl shadow p-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Enter Amount (Rp)</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                    </div>
                    <input type="number" x-model="amount" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-12 py-3 sm:text-lg font-bold border-gray-300 rounded-lg placeholder-gray-300" placeholder="0">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">IDR</span>
                    </div>
                </div>
                <div class="flex space-x-2 mt-4">
                    <button @click="amount = 100000" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium text-gray-700 transition">100.000</button>
                    <button @click="amount = 500000" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium text-gray-700 transition">500.000</button>
                    <button @click="amount = 1000000" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium text-gray-700 transition">1.000.000</button>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-bold text-gray-800 mb-4">Select Payment Method</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div @click="method = 'va'" :class="{'ring-2 ring-indigo-500 bg-indigo-50': method === 'va'}" class="border rounded-lg p-4 cursor-pointer hover:bg-gray-50 transition relative">
                        <div class="flex items-center">
                             <div class="h-10 w-10 text-indigo-600 bg-indigo-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                             </div>
                             <div class="ml-3">
                                 <span class="block font-bold text-gray-800">Virtual Account</span>
                                 <span class="block text-xs text-slategray-500">Auto-verification</span>
                             </div>
                        </div>
                        <div x-show="method === 'va'" class="absolute top-4 right-4 text-indigo-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                     <div @click="method = 'bank'" :class="{'ring-2 ring-indigo-500 bg-indigo-50': method === 'bank'}" class="border rounded-lg p-4 cursor-pointer hover:bg-gray-50 transition relative">
                        <div class="flex items-center">
                             <div class="h-10 w-10 text-gray-600 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                             </div>
                             <div class="ml-3">
                                 <span class="block font-bold text-gray-800">Manual Transfer</span>
                                 <span class="block text-xs text-gray-500">Requires proof of payment</span>
                             </div>
                        </div>
                         <div x-show="method === 'bank'" class="absolute top-4 right-4 text-indigo-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg transition" :disabled="amount < 10000" :class="{'opacity-50 cursor-not-allowed': amount < 10000}">
                Proceed to Payment
            </button>
             <p class="text-center text-xs text-gray-400">Secure encrypted transaction powered by LitePay.</p>
        </div>
    </div>
@endsection
