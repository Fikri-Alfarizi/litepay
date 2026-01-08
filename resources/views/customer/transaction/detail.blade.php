@extends('layouts.mobile')

@section('content')
<!-- Header -->
<div class="bg-blue-600 px-6 pt-12 pb-24 text-white relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
         <svg class="w-full h-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
             <path d="M0 0 L100 0 L100 100 L0 100 Z" />
         </svg>
    </div>
    
    <div class="relative z-10 text-center">
        <h1 class="text-xl font-bold mb-1">Transaction Detail</h1>
        <p class="text-blue-100 text-sm">Thank you for your transaction</p>
    </div>
</div>

<div class="px-6 -mt-16 pb-12 relative z-20">
    <!-- Receipt Card -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-6 relative">
        <!-- Punch Holes Decoration -->
        <div class="absolute top-0 left-0 w-full h-4 bg-blue-600"></div>
        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-6 h-6 bg-blue-600 rounded-full"></div>
        
        <div class="p-8 text-center border-b border-dashed border-gray-200">
             @if($transaction->status == 'PAID' || $transaction->status == 'SUCCESS')
                <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Success</h2>
            @elseif($transaction->status == 'PENDING')
                <div class="w-16 h-16 bg-yellow-100 text-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Pending</h2>
            @else
                <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                     <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Failed</h2>
            @endif

            <p class="text-gray-500 text-sm mt-1 mb-6">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
            
            <p class="text-gray-400 text-xs uppercase tracking-wide mb-1">Total Amount</p>
            <h3 class="text-3xl font-extrabold text-blue-600 tracking-tight">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</h3>
        </div>

        <div class="p-6 bg-gray-50">
            <div class="space-y-4">
                <div class="flex justify-between items-center text-sm">
                     <span class="text-gray-500">Payment Method</span>
                     <span class="font-bold text-gray-800 capitalize">{{ str_replace('_', ' ', $transaction->payment_method) }}</span>
                </div>
                 <div class="flex justify-between items-center text-sm">
                     <span class="text-gray-500">Merchant</span>
                     <span class="font-bold text-gray-800">{{ $transaction->merchant->name ?? 'LitePay System' }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                     <span class="text-gray-500">Product</span>
                     <span class="font-bold text-gray-800">{{ $transaction->product_name ?? 'Payment' }}</span>
                </div>
                 <div class="flex justify-between items-center text-sm pt-4 border-t border-dashed border-gray-200">
                     <span class="text-gray-500">Invoice ID</span>
                     <span class="font-mono text-gray-700 bg-white px-2 py-1 rounded border">{{ $transaction->invoice_id }}</span>
                </div>
                 <div class="flex justify-between items-center text-sm">
                     <span class="text-gray-500">Reference ID</span>
                     <span class="font-mono text-gray-700 bg-white px-2 py-1 rounded border">{{ $transaction->reference_id }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <a href="{{ route('store.index') }}" class="block w-full bg-blue-600 text-white font-bold py-4 rounded-xl text-center shadow-lg hover:bg-blue-700 transition">
        Back to Home
    </a>
</div>
@endsection
