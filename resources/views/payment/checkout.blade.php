<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Checkout - {{ $transaction->reference_id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-indigo-600 text-white p-6 shadow-md text-center">
        <h1 class="font-bold text-lg mb-1">LitePay Secure Payment</h1>
        <div class="text-xs opacity-75">Ref: {{ $transaction->reference_id }}</div>
        <div class="text-3xl font-bold mt-4">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</div>
    </div>

    <!-- Merchant Info -->
    <div class="p-4 max-w-lg mx-auto -mt-4">
        <div class="bg-white rounded-xl shadow-sm p-4 flex justify-between items-center mb-6">
            <div>
                <p class="text-xs text-gray-500 uppercase">Merchant</p>
                <div class="font-bold text-gray-800">{{ $transaction->merchant->name }}</div>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 uppercase">Invoice</p>
                <div class="font-mono text-gray-800">{{ $transaction->invoice_id }}</div>
            </div>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl mb-6">
            <h3 class="font-bold text-yellow-800 text-sm mb-1">Payment Simulation</h3>
            <p class="text-xs text-yellow-700">This is a simulated payment page. No real money will be deducted.</p>
        </div>

        <form action="{{ route('payment.process', $transaction->reference_id) }}" method="POST" class="space-y-4">
            @csrf

            <button type="submit" name="action" value="pay"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-green-500/30 transition transform active:scale-[0.98] flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                SIMULATE SUCCESS
            </button>

            <button type="submit" name="action" value="cancel"
                class="w-full bg-red-100 hover:bg-red-200 text-red-700 font-bold py-4 rounded-xl transition transform active:scale-[0.98] flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                SIMULATE FAILURE
            </button>
        </form>
    </div>
</body>

</html>