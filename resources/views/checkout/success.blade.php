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

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden relative">
        <div class="absolute top-0 w-full h-2 bg-green-500"></div>
        <div class="p-8 text-center">
            <div
                class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Successful!</h1>
            <p class="text-gray-500 mb-8">Thank you for your payment.</p>

            <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left border border-gray-100">
                <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200">
                    <span class="text-gray-500">Amount Paid</span>
                    <span class="text-xl font-bold text-gray-900">IDR
                        {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Reference ID</span>
                        <span
                            class="text-gray-700 text-sm font-mono bg-gray-200 px-2 py-0.5 rounded">{{ $transaction->reference_id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Date</span>
                        <span class="text-gray-700 text-sm">{{ $transaction->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Payment Method</span>
                        <span
                            class="text-gray-700 text-sm">{{ ucfirst($transaction->payment_channel ?? 'Unknown') }}</span>
                    </div>
                </div>
            </div>

            <a href="/"
                class="block w-full bg-slate-900 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-slate-800 transition duration-300">
                Return to Merchant Site
            </a>
        </div>
        <div class="bg-gray-50 p-4 text-center border-t border-gray-100">
            <p class="text-xs text-gray-400">Processed securely by LitePay</p>
        </div>
    </div>
</body>

</html>