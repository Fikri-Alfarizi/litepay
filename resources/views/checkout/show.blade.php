<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay to {{ $transaction->merchant->name }} - LitePay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen pb-32">
    <!-- Top Header -->
    <div class="bg-white shadow-sm p-4 sticky top-0 z-10 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <a href="{{ route('store.index') }}" class="text-gray-500 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="font-bold text-lg text-gray-800">Checkout</h1>
        </div>
        <div class="text-sm font-semibold text-blue-600">IDR {{ number_format($transaction->amount, 0, ',', '.') }}
        </div>
    </div>

    <div class="p-4 max-w-lg mx-auto">
        <!-- Merchant Info -->
        <div class="bg-white p-4 rounded-xl shadow-sm mb-4 flex items-center gap-4">
            <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Merchant</p>
                <h2 class="font-bold text-gray-800">{{ $transaction->merchant->name }}</h2>
                <p class="text-xs text-gray-400">{{ $transaction->reference_id }}</p>
            </div>
        </div>

        <form action="{{ route('checkout.process', $transaction->reference_id) }}" method="POST">
            @csrf

            <!-- Payment Methods -->
            <h3 class="font-bold text-gray-800 mb-3 mt-6">Select Payment Method</h3>
            <div class="space-y-3">
                <!-- Bank Transfer Option -->
                <label class="block relative group cursor-pointer">
                    <input type="radio" name="channel" value="bank_transfer" checked class="peer sr-only">
                    <div
                        class="bg-white p-4 rounded-xl shadow-sm border-2 border-transparent peer-checked:border-blue-600 peer-checked:bg-blue-50 transition flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="bg-gray-100 p-2 rounded-lg text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Bank Transfer</h4>
                                <p class="text-xs text-gray-500">BCA, Mandiri, BRI, BNI</p>
                            </div>
                        </div>
                        <div class="hidden peer-checked:block text-blue-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </label>

                <!-- E-Wallet Option -->
                <label class="block relative group cursor-pointer">
                    <input type="radio" name="channel" value="ewallet" class="peer sr-only">
                    <div
                        class="bg-white p-4 rounded-xl shadow-sm border-2 border-transparent peer-checked:border-blue-600 peer-checked:bg-blue-50 transition flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="bg-gray-100 p-2 rounded-lg text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">QRIS / E-Wallet</h4>
                                <p class="text-xs text-gray-500">GoPay, OVO, Dana, ShopeePay</p>
                            </div>
                        </div>
                        <div class="hidden peer-checked:block text-blue-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </label>
            </div>

            <!-- Sticky Bottom Button -->
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t p-4 z-50">
                <div class="max-w-lg mx-auto">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-full shadow-lg transition active:scale-[0.98]">
                        Pay IDR {{ number_format($transaction->amount, 0, ',', '.') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>