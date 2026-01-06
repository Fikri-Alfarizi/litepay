@extends('layouts.mobile')

@section('content')
<div class="bg-green-500 min-h-screen flex flex-col items-center justify-center p-6 text-center text-white relative overflow-hidden">
    <!-- Confetti / Decoration -->
    <div class="absolute top-0 left-0 w-full h-full opacity-20 pointer-events-none">
         <svg class="w-full h-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
             <circle cx="20" cy="20" r="10" />
             <circle cx="80" cy="80" r="15" />
             <circle cx="50" cy="50" r="5" />
         </svg>
    </div>

    <div class="bg-white rounded-full p-6 mb-6 shadow-xl animate-bounce">
        <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
        </svg>
    </div>

    <h1 class="text-2xl font-bold mb-2">Payment Successful!</h1>
    <p class="text-green-100 mb-8">Your transaction has been processed.</p>

    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 w-full max-w-sm border border-white/20 mb-8">
        <div class="flex justify-between mb-2">
            <span class="text-green-100">Amount Paid</span>
            <span class="font-bold">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-green-100">Reference</span>
            <span class="font-mono text-sm opacity-90">{{ $transaction->reference_id }}</span>
        </div>
    </div>

    <a href="{{ route('store.index') }}" class="bg-white text-green-600 font-bold py-3 px-8 rounded-full shadow-lg hover:bg-green-50 transition transform hover:scale-105">
        Back to Store
    </a>
</div>
@endsection