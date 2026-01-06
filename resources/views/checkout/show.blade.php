@extends('layouts.mobile')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Header -->
    <div class="bg-white shadow-sm px-6 py-4 flex items-center gap-4 sticky top-0 z-50">
        <a href="{{ route('store.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <h1 class="text-lg font-bold">Payment</h1>
    </div>

    <div class="p-6">
        <!-- Timer -->
        <div class="bg-orange-50 text-orange-600 px-4 py-3 rounded-xl mb-6 flex justify-between items-center text-sm font-medium">
            <span>Complete payment in</span>
            <span id="countdown">23:59:59</span>
        </div>

        <!-- Amount -->
        <div class="bg-white p-6 rounded-2xl shadow-sm mb-6 text-center">
            <p class="text-gray-500 text-sm mb-1">Total Payment</p>
            <h2 class="text-3xl font-bold text-gray-800">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</h2>
            <div class="mt-4 flex justify-between text-sm text-gray-500 border-t pt-4">
                <span>Order ID</span>
                <span class="font-mono text-gray-700">{{ $transaction->invoice_id }}</span>
            </div>
        </div>

        <!-- Payment Method (QRIS) -->
        <div class="bg-white p-6 rounded-2xl shadow-sm mb-6">
            <h3 class="font-bold text-gray-800 mb-4">Scan QRIS</h3>
            <div class="flex flex-col items-center">
                <div class="bg-gray-100 p-4 rounded-xl mb-4">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $transaction->reference_id }}" alt="QR Code" class="w-48 h-48 mix-blend-multiply">
                </div>
                <p class="text-sm text-center text-gray-500">Scan this QR code with any e-wallet or banking app to pay.</p>
            </div>
        </div>

        <!-- Order Details -->
        <div class="bg-white p-6 rounded-2xl shadow-sm mb-6">
            <h3 class="font-bold text-gray-800 mb-4">Order Details</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Product</span>
                    <span class="font-medium text-right">{{ $transaction->product_name ?? 'Digital Product' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Destination</span>
                    <span class="font-medium">{{ $transaction->destination_number }}</span>
                </div>
                <hr class="border-dashed border-gray-200">
                <div class="flex justify-between">
                    <span class="text-gray-500">Price</span>
                    <span>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Admin Fee</span>
                    <span>Rp {{ number_format($transaction->fee, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tax (11%)</span>
                    <span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-gray-800 pt-2 border-t mt-2">
                    <span>Total</span>
                    <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Simulation Button -->
        <button onclick="simulatePayment()" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-blue-700 transition mb-4">
            Simulate Payment (Dev Only)
        </button>
        
        <a href="{{ route('store.index') }}" class="block text-center text-gray-500 font-medium text-sm">Cancel Transaction</a>
    </div>
</div>

<script>
    function simulatePayment() {
        const btn = document.querySelector('button');
        btn.disabled = true;
        btn.innerText = 'Processing...';
        
        fetch("{{ route('checkout.simulate', $transaction->reference_id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.message === 'Payment Successful') {
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
                btn.disabled = false;
                btn.innerText = 'Simulate Payment (Dev Only)';
            }
        });
    }

    // Polling status
    setInterval(() => {
        fetch("{{ route('checkout.status', $transaction->reference_id) }}")
            .then(res => res.json())
            .then(data => {
                if (data.status === 'SUCCESS') {
                    window.location.reload();
                }
            });
    }, 3000);
</script>
@endsection