<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Transactions - LitePay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen pb-20">
    <!-- Top Bar -->
    <div class="bg-white shadow-sm p-4 flex items-center justify-between sticky top-0 z-10">
        <div class="flex items-center gap-2">
            <a href="{{ route('store.index') }}" class="text-gray-500 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="font-bold text-lg text-gray-800">My History</h1>
        </div>
    </div>

    <div class="max-w-md mx-auto p-4">
        <!-- User Info -->
        <div class="bg-blue-600 rounded-xl p-6 text-white shadow-lg mb-6">
            <div class="text-blue-100 text-sm mb-1">Welcome back,</div>
            <div class="font-bold text-2xl">{{ Auth::user()->name }}</div>
            <div class="text-blue-200 text-sm mt-1">{{ Auth::user()->email }}</div>
        </div>

        <h2 class="font-bold text-gray-800 mb-4">Recent Transactions</h2>

        @if($transactions->count() > 0)
            <div class="space-y-4">
                @foreach($transactions as $transaction)
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-transparent hover:border-blue-500 transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <div class="font-bold text-gray-800">
                                    {{ $transaction->merchant->name ?? 'Unknown Merchant' }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ $transaction->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="block font-bold text-gray-800">Rp
                                    {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                <span
                                    class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide
                                            {{ $transaction->status === 'success' ? 'bg-green-100 text-green-600' :
                    ($transaction->status == 'pending' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }}">
                                    {{ $transaction->status }}
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-400 font-mono">{{ $transaction->reference_id }}</span>
                            @if($transaction->status === 'pending')
                                <a href="{{ route('checkout.show', $transaction->reference_id) }}"
                                    class="text-xs font-bold text-blue-600 hover:underline">Pay Now</a>
                            @else
                                <a href="{{ route('checkout.success', $transaction->reference_id) }}"
                                    class="text-xs font-bold text-gray-500 hover:text-gray-800">View Receipt</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-xl">
                <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 mb-1">No Transactions Yet</h3>
                <p class="text-gray-500 text-sm mb-6">You haven't made any purchases yet.</p>
                <a href="{{ route('store.index') }}"
                    class="bg-blue-600 text-white font-bold py-3 px-6 rounded-full shadow-lg hover:bg-blue-700 transition">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>

    <!-- Footer nav -->
    <div
        class="fixed bottom-0 w-full bg-white border-t border-gray-200 py-3 px-6 flex justify-between items-center text-xs text-gray-500 z-50">
        <a href="{{ route('store.index') }}" class="flex flex-col items-center hover:text-blue-600">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            Home
        </a>
        <a href="{{ route('customer.history') }}" class="flex flex-col items-center text-blue-600 font-bold">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                </path>
            </svg>
            History
        </a>
        <a href="{{ route('customer.profile') }}" class="flex flex-col items-center hover:text-blue-600">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Profile
        </a>
    </div>
</body>

</html>