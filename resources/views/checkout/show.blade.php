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
            <h2 class="text-3xl font-bold text-gray-800">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</h2>
            <div class="mt-4 flex justify-between text-sm text-gray-500 border-t pt-4">
                <span>Order ID</span>
                <span class="font-mono text-gray-700">{{ $transaction->invoice_id }}</span>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="space-y-4 mb-24">
            <h3 class="font-bold text-gray-800 px-1">Payment Method</h3>
            
            <!-- LitePay Balance -->
            <label class="block bg-white p-4 rounded-2xl shadow-sm cursor-pointer border-2 has-[:checked]:border-blue-500 transition relative overflow-hidden">
                <input type="radio" name="payment_method" value="balance" class="peer hidden" checked onchange="togglePaymentMethod('balance')">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800">LitePay Balance</p>
                        @auth
                            <p class="text-sm {{ Auth::user()->balance >= $transaction->amount ? 'text-green-600' : 'text-red-500' }}">
                                Balance: Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}
                            </p>
                        @else
                            <p class="text-sm text-gray-500">Login to use balance</p>
                        @endauth
                    </div>
                </div>
                <!-- Selection Indicator -->
                <div class="absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </label>

            <!-- QRIS -->
            <label class="block bg-white p-4 rounded-2xl shadow-sm cursor-pointer border-2 has-[:checked]:border-blue-500 transition relative">
                <input type="radio" name="payment_method" value="qris" class="peer hidden" onchange="togglePaymentMethod('qris')">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                         <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800">QRIS</p>
                        <p class="text-sm text-gray-500">Scan with any e-wallet</p>
                    </div>
                </div>
                 <!-- Selection Indicator -->
                <div class="absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                
                <!-- QR details (hidden by default) -->
                <div id="qris-details" class="hidden mt-4 pt-4 border-t">
                        <a href="{{ route('gateway.simulator.show', $transaction->reference_id) }}" target="_blank" class="flex flex-col items-center group">
                            <div class="bg-white p-2 rounded-xl mb-2 border-2 border-dashed border-blue-200 group-hover:border-blue-400 transition">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode(route('gateway.simulator.show', $transaction->reference_id)) }}" alt="QR Code" class="w-48 h-48 mix-blend-multiply">
                            </div>
                            <span class="text-[11px] text-blue-600 font-bold group-hover:underline mb-1">Click to Open Simulator</span>
                        </a>
                        <div class="mt-3 p-2 bg-yellow-50 rounded-lg text-left">
                            <p class="text-[10px] text-yellow-700 italic leading-tight">
                                <strong>💡 Phone Scan Tip:</strong> Access this site through your PC's <strong>Local IP</strong> (e.g. 192.168.x.x) so your phone can reach the simulator when scanned.
                            </p>
                        </div>
                        <p class="text-[10px] text-center text-gray-400 mt-2">Ref: {{ $transaction->reference_id }}</p>
                    </div>
                </div>
            </label>

            <!-- Virtual Accounts (Mock) -->
            <label class="block bg-white p-4 rounded-2xl shadow-sm cursor-pointer border-2 has-[:checked]:border-blue-500 transition relative">
                <input type="radio" name="payment_method" value="va" class="peer hidden" onchange="togglePaymentMethod('va')">
                <div class="flex items-center gap-4">
                     <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                         <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800">Virtual Account</p>
                        <p class="text-sm text-gray-500">BCA, Mandiri, BRI, BNI</p>
                    </div>
                </div>
                 <!-- Selection Indicator -->
                <div class="absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <!-- VA Details -->
                <div id="va-details" class="hidden mt-4 pt-4 border-t">
                     <div class="bg-gray-50 p-3 rounded-lg flex justify-between items-center mb-2">
                        <span class="font-bold text-gray-700">BCA</span>
                        <span class="font-mono text-sm">8271{{ rand(10000000, 99999999) }}</span>
                    </div>
                </div>
            </label>
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
                    <span>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <button onclick="processPayment()" id="pay-btn" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-blue-700 transition mb-4">
            Pay Now
        </button>
        
        <a href="{{ route('checkout.cancel', $transaction->reference_id) }}" class="block text-center text-gray-500 font-medium text-sm">Cancel Transaction</a>
    </div>
</div>

<script>
    let selectedMethod = 'balance';

    function togglePaymentMethod(method) {
        selectedMethod = method;
        
        // Hide all details first
        document.getElementById('qris-details').classList.add('hidden');
        document.getElementById('va-details').classList.add('hidden');

        // Show details and update button text
        const btn = document.getElementById('pay-btn');
        if (method === 'qris') {
            document.getElementById('qris-details').classList.remove('hidden');
            btn.innerText = 'Run Simulation (QRIS)';
        } else if (method === 'va') {
            document.getElementById('va-details').classList.remove('hidden');
            btn.innerText = 'Run Simulation (VA)';
        } else {
            btn.innerText = 'Pay Now (Rp {{ number_format($transaction->amount, 0, ',', '.') }})';
        }
    }

    function processPayment() {
        const btn = document.getElementById('pay-btn');
        btn.disabled = true;
        btn.innerText = 'Processing...';

        let url = "{{ route('checkout.pay_balance', $transaction->reference_id) }}";
        
        // If external method, use simulator
        if (selectedMethod !== 'balance') {
            window.open("{{ route('gateway.simulator.show', $transaction->reference_id) }}", "_blank");
            btn.innerText = 'Waiting for Payment...';
            return;
        }
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.message === 'Payment Successful') {
                window.location.href = "{{ route('checkout.success', $transaction->reference_id) }}";
            } else {
                alert('Error: ' + data.message);
                btn.disabled = false;
                btn.innerText = 'Retry Payment';
            }
        })
        .catch(err => {
             alert('Error processing payment');
             btn.disabled = false;
        });
    }

    // Polling status
    setInterval(() => {
        fetch("{{ route('checkout.status', $transaction->reference_id) }}")
            .then(res => res.json())
            .then(data => {
                if (data.status === 'SUCCESS') {
                    window.location.href = "{{ route('checkout.success', $transaction->reference_id) }}";
                }
            });
    }, 3000);
</script>
@endsection