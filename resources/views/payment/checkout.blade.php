<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Checkout - {{ $transaction->reference_id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-lg w-full max-w-md">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-indigo-600">LitePay Checkout</h1>
            <p class="text-gray-500">Secure Payment Simulation</p>
        </div>
        
        <div class="bg-gray-50 p-4 rounded mb-6 border">
            <div class="flex justify-between mb-2">
                <span class="text-gray-600">Merchant</span>
                <span class="font-bold">{{ $transaction->merchant->name }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="text-gray-600">Invoice ID</span>
                <span class="font-mono">{{ $transaction->invoice_id }}</span>
            </div>
            <div class="flex justify-between text-lg border-t pt-2 mt-2">
                <span class="font-bold">Total</span>
                <span class="font-bold text-indigo-700">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <form action="{{ route('payment.process', $transaction->reference_id) }}" method="POST" class="space-y-3">
            @csrf
            <button type="submit" name="action" value="pay" class="w-full bg-green-600 text-white font-bold py-3 rounded hover:bg-green-700 transition">
                CONFIRM PAYMENT (SUCCESS)
            </button>
            <button type="submit" name="action" value="cancel" class="w-full bg-gray-200 text-gray-700 font-bold py-3 rounded hover:bg-gray-300 transition">
                CANCEL TRANSACTION (FAILED)
            </button>
        </form>

        <p class="mt-4 text-xs text-center text-gray-400">This is a simulation. No real money is processed.</p>
    </div>
</body>
</html>
