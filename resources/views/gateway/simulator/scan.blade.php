@extends('layouts.mobile')

@section('content')
<div class="bg-gray-900 min-h-screen text-white flex flex-col items-center justify-center p-6 text-center">
    <div class="mb-8">
        <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
        </div>
        <h1 class="text-2xl font-bold">LitePay Bank</h1>
        <p class="text-gray-400">Simulation App</p>
    </div>

    <div class="bg-white text-gray-800 w-full rounded-3xl p-8 mb-8">
        <p class="text-gray-500 text-sm mb-1">Confirm Payment to</p>
        <p class="font-bold text-lg mb-6">{{ $transaction->merchant->name }}</p>

        <div class="text-3xl font-bold mb-2">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</div>
        <p class="text-xs text-gray-400 mb-8">Ref: {{ $transaction->reference_id }}</p>

        <button onclick="simulatePay()" id="pay-btn" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-blue-700 transition">
            Confirm & Pay
        </button>
    </div>

    <p class="text-gray-500 text-sm italic">This is a GATEWAY simulator. Paying here will send a callback to the Merchant Database.</p>
</div>

<script>
function simulatePay() {
    const btn = document.getElementById('pay-btn');
    btn.disabled = true;
    btn.innerText = 'Processing...';

    fetch("{{ route('gateway.simulator.pay', $transaction->reference_id) }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        btn.innerText = '✅ Payment Sent';
        setTimeout(() => {
            alert('Payment notification sent to Merchant!');
            window.close(); // Try to close tab if popped up
        }, 1000);
    })
    .catch(err => {
        alert('Error simulating payment');
        btn.disabled = false;
        btn.innerText = 'Retry';
    });
}
</script>
@endsection
