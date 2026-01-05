<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status - {{ $transaction->reference_id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-lg w-full max-w-md text-center">
        @if($transaction->status === 'SUCCESS')
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h1 class="text-2xl font-bold text-green-600 mb-2">Payment Successful!</h1>
        @else
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <h1 class="text-2xl font-bold text-red-600 mb-2">Transaction Failed</h1>
        @endif

        <p class="text-gray-600 mb-6">
            Your transaction for <span class="font-bold">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span> has been processed.
        </p>

        <div class="bg-gray-50 p-4 rounded text-left text-sm space-y-2 mb-6">
            <div class="flex justify-between">
                <span>Reference ID</span>
                <span class="font-mono">{{ $transaction->reference_id }}</span>
            </div>
            <div class="flex justify-between">
                <span>Paid At</span>
                <span>{{ $transaction->paid_at ?? '-' }}</span>
            </div>
        </div>

        <p class="text-sm text-gray-500">You can close this window now.</p>
    </div>
</body>
</html>
