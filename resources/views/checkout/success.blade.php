<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - LitePay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen pb-32">
    <!-- Success Header -->
    <div class="bg-green-500 text-white p-12 text-center relative overflow-hidden">
        <!-- Decor circles -->
        <div class="absolute top-0 left-0 w-32 h-32 bg-white opacity-10 rounded-full -translate-x-1/2 -translate-y-1/2">
        </div>
        <div
            class="absolute bottom-0 right-0 w-48 h-48 bg-white opacity-10 rounded-full translate-x-1/3 translate-y-1/3">
        </div>

        <div class="relative z-10">
            <div
                class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl animate-bounce">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold mb-1">Payment Successful!</h1>
            <p class="text-green-100 text-sm">Thank you for your payment.</p>
        </div>
    </div>

    <!-- Receipt Details -->
    <div class="p-4 max-w-lg mx-auto -mt-6 relative z-10">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="text-center border-b border-gray-100 pb-6 mb-6">
                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total Paid</p>
                <div class="text-3xl font-bold text-gray-800">IDR {{ number_format($transaction->amount, 0, ',', '.') }}
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Reference ID</span>
                    <span
                        class="font-mono text-gray-700 bg-gray-100 px-2 py-1 rounded text-xs">{{ $transaction->reference_id }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Date & Time</span>
                    <span
                        class="text-gray-800 text-sm font-medium">{{ $transaction->updated_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Payment Method</span>
                    <span
                        class="text-gray-800 text-sm font-medium capitalize">{{ str_replace('_', ' ', $transaction->payment_channel ?? 'Manual') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Merchant</span>
                    <span class="text-gray-800 text-sm font-medium">{{ $transaction->merchant->name }}</span>
                </div>
            </div>
        </div>

        <div class="text-center text-gray-400 text-xs">
            A copy of this receipt has been saved to your history.
        </div>
    </div>

    <!-- Bottom Action Button -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t p-4 z-50">
        <div class="max-w-lg mx-auto">
            <a href="{{ route('store.index') }}"
                class="block w-full text-center bg-slate-900 text-white font-bold py-4 rounded-full shadow-lg hover:bg-slate-800 transition duration-300 transform active:scale-[0.98]">
                Return to Merchant Site
            </a>
        </div>
    </div>
</body>

</html>

</html>