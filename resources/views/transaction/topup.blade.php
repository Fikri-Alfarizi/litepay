@extends('layouts.mobile')

@section('content')
    <div class="bg-blue-600 text-white pb-10 pt-6 px-6 rounded-b-[2rem] shadow-lg relative">
        <a href="{{ route('store.index') }}" class="absolute top-6 left-6 text-blue-100 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h1 class="text-2xl font-bold text-center">Top Up Balance</h1>
        <p class="text-blue-200 text-center text-sm mt-1">Add funds to your LitePay wallet</p>
    </div>

    <div class="px-6 -mt-8">
        <div class="bg-white rounded-2xl shadow-md p-6">
            <form action="{{ route('transaction.processTopUp') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Amount</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500 font-bold">Rp</span>
                        <input type="number" name="amount" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent font-bold text-gray-800" placeholder="0" min="10000" step="1000" required>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 ml-1">Minimum top up Rp 10.000</p>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-6">
                    <button type="button" onclick="setAmount(20000)" class="border border-gray-200 rounded-lg py-2 text-sm font-medium text-gray-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition">Rp 20.000</button>
                    <button type="button" onclick="setAmount(50000)" class="border border-gray-200 rounded-lg py-2 text-sm font-medium text-gray-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition">Rp 50.000</button>
                    <button type="button" onclick="setAmount(100000)" class="border border-gray-200 rounded-lg py-2 text-sm font-medium text-gray-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition">Rp 100.000</button>
                    <button type="button" onclick="setAmount(200000)" class="border border-gray-200 rounded-lg py-2 text-sm font-medium text-gray-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition">Rp 200.000</button>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-0.5">
                    Continue to Payment
                </button>
            </form>
        </div>
    </div>

    <script>
        function setAmount(amount) {
            document.querySelector('input[name="amount"]').value = amount;
        }
    </script>
@endsection
