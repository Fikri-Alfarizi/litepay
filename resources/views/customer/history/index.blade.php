@extends('layouts.mobile')

@section('content')
    <!-- Top Bar -->
    <div class="bg-white shadow-sm p-4 flex items-center justify-between sticky top-0 z-10">
        <div class="flex items-center gap-2">
            <a href="{{ route('store.index') }}" class="text-gray-500 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="font-bold text-lg text-gray-800">My History</h1>
        </div>
    </div>

    <div class="p-4">
        <!-- User Info -->
        <div class="bg-blue-600 rounded-xl p-6 text-white shadow-lg mb-6">
            <div class="text-blue-100 text-sm mb-1">Welcome back,</div>
            <div class="font-bold text-2xl">{{ Auth::user()->name }}</div>
            <div class="text-blue-200 text-sm mt-1">{{ Auth::user()->email }}</div>
        </div>

        <h2 class="font-bold text-gray-800 mb-4">Recent Transactions</h2>

        @if($transactions->count() > 0)
            <div class="space-y-4">
                @foreach($transactions as $transaction)
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-transparent hover:border-blue-500 transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <div class="font-bold text-gray-800">
                                    {{ $transaction->product_name }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ $transaction->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="block font-bold text-gray-800">Rp
                                    {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                <span
                                    class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide
                                            {{ ($transaction->status === 'SUCCESS' || $transaction->status === 'PAID') ? 'bg-green-100 text-green-600' :
                    (($transaction->status == 'PENDING' || $transaction->status == 'UNPAID') ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }}">
                                    {{ $transaction->status }}
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-400 font-mono">{{ $transaction->gateway_reference_id ?? '-' }}</span>
                            
                            @if($transaction->gateway_reference_id)
                                @if($transaction->status === 'PENDING' || $transaction->status === 'UNPAID')
                                    <a href="{{ route('checkout.show', $transaction->gateway_reference_id) }}"
                                        class="text-xs font-bold text-blue-600 hover:underline">Pay Now</a>
                                @else
                                    <a href="{{ route('checkout.success', $transaction->gateway_reference_id) }}"
                                        class="text-xs font-bold text-gray-500 hover:text-gray-800">View Receipt</a>
                                @endif
                            @else
                                <span class="text-xs text-gray-300 italic">Reference not available</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-xl">
                <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 mb-1">No Transactions Yet</h3>
                <p class="text-gray-500 text-sm mb-6">You haven't made any purchases yet.</p>
                <a href="{{ route('store.index') }}"
                    class="bg-blue-600 text-white font-bold py-3 px-6 rounded-full shadow-lg hover:bg-blue-700 transition">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
@endsection