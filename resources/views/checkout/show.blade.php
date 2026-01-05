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

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">

        <!-- Left Panel: Order Details -->
        <div class="bg-slate-900 text-white p-8 md:w-5/12 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 mb-8">
                    <div class="bg-blue-600 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight">LitePay</span>
                </div>

                <div class="mb-8">
                    <p class="text-slate-400 text-sm uppercase tracking-wider mb-2">Pay to</p>
                    <h2 class="text-2xl font-bold">{{ $transaction->merchant->name }}</h2>
                    <p class="text-slate-400 text-sm mt-1">{{ $transaction->merchant->user->email }}</p>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center py-4 border-t border-slate-700">
                        <span class="text-slate-300">Reference</span>
                        <span class="font-mono text-white">{{ $transaction->reference_id }}</span>
                    </div>
                    <div class="flex justify-between items-center py-4 border-t border-slate-700">
                        <span class="text-slate-300">Total Due</span>
                        <span class="text-2xl font-bold text-white">IDR
                            {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-700 text-center md:text-left">
                <a href="#" class="text-xs text-slate-500 hover:text-slate-300 transition flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Cancel Payment
                </a>
            </div>
        </div>

        <!-- Right Panel: Payment Method -->
        <div class="p-8 md:w-7/12 bg-white">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Select Payment Method</h3>

            <form action="{{ route('checkout.process', $transaction->reference_id) }}" method="POST">
                @csrf

                <div class="space-y-4 mb-8">
                    <!-- Bank Transfer Option -->
                    <label
                        class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all group">
                        <input type="radio" name="channel" value="bank_transfer" checked class="peer sr-only">
                        <div class="flex items-center gap-4 w-full">
                            <div
                                class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 group-hover:text-blue-600 peer-checked:bg-blue-100 peer-checked:text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 group-hover:text-blue-700">Bank Transfer</h4>
                                <p class="text-sm text-gray-500">BCA, Mandiri, BRI, BNI</p>
                            </div>
                            <div class="peer-checked:block hidden text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div
                            class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-600 rounded-xl pointer-events-none">
                        </div>
                    </label>

                    <!-- E-Wallet Option -->
                    <label
                        class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all group">
                        <input type="radio" name="channel" value="ewallet" class="peer sr-only">
                        <div class="flex items-center gap-4 w-full">
                            <div
                                class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 group-hover:text-blue-600 peer-checked:bg-blue-100 peer-checked:text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 group-hover:text-blue-700">QRIS / E-Wallet</h4>
                                <p class="text-sm text-gray-500">GoPay, OVO, Dana, ShopeePay</p>
                            </div>
                            <div class="peer-checked:block hidden text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div
                            class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-600 rounded-xl pointer-events-none">
                        </div>
                    </label>
                </div>

                <div class="flex items-center gap-2 mb-6 text-sm text-gray-500 bg-gray-50 p-3 rounded-lg">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                    <span>Payments are secure and encrypted.</span>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/30 transition duration-300 transform active:scale-[0.98]">
                    Pay IDR {{ number_format($transaction->amount, 0, ',', '.') }}
                </button>
            </form>
        </div>
    </div>
</body>

</html>