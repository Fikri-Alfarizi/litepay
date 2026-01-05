<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy {{ $categoryName }} - LitePay</title>
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
    <div class="bg-white shadow-sm p-4 flex items-center sticky top-0 z-10">
        <a href="{{ route('store.index') }}" class="mr-4 text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
        </a>
        <h1 class="font-bold text-lg text-gray-800">Buy {{ $categoryName }}</h1>
    </div>

    <div class="max-w-md mx-auto p-4">

        <!-- Input Section -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">
                {{ $slug === 'pln' ? 'Customer ID / Meter No' : 'Phone Number' }}
            </label>
            <div class="flex items-center gap-2">
                <input type="tel" id="identifierInput" class="w-full text-xl font-semibold outline-none py-2 placeholder-gray-300"
                    placeholder="08..." autofocus>
                @if($slug !== 'pln')
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                @endif
            </div>
        </div>

        <!-- Products Grid -->
        <h2 class="font-bold text-gray-800 mb-4">Select Product</h2>
        <div class="grid grid-cols-2 gap-4">
            @foreach($products as $product)
                <form action="{{ route('store.purchase') }}" method="POST" class="contents">
                    @csrf
                    <input type="hidden" name="product_name" value="{{ $product['name'] }}">
                    <input type="hidden" name="amount" value="{{ $product['amount'] }}">
                    <!-- In real app, JS would copy the phone number input to a hidden field here -->
                    <input type="hidden" name="identifier" value="">

                    <button type="submit"
                        class="bg-white p-4 rounded-xl shadow-sm border border-transparent hover:border-blue-500 hover:shadow-md transition text-left group">
                        <div class="flex justify-between items-start mb-2">
                            <span
                                class="text-xs font-bold bg-blue-100 text-blue-600 px-2 py-1 rounded">{{ $categoryName }}</span>
                        </div>
                        <div class="font-bold text-gray-800 mb-1">{{ $product['name'] }}</div>
                        <div class="text-orange-600 font-bold text-lg">Rp
                            {{ number_format($product['amount'], 0, ',', '.') }}
                        </div>
                        <p class="text-xs text-gray-400 mt-2">{{ $product['description'] }}</p>
                    </button>
                </form>
            @endforeach
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputField = document.querySelector('input[type="tel"]');
            const hiddenInputs = document.querySelectorAll('input[name="identifier"]');
            const submitButtons = document.querySelectorAll('button[type="submit"]');

            function updateState() {
                const value = inputField.value.trim();
                const isValid = value.length >= 8; // Basic validation

                // Update hidden inputs
                hiddenInputs.forEach(input => input.value = value);

                // Enable/Disable buttons
                submitButtons.forEach(btn => {
                    if (isValid) {
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                        btn.classList.add('hover:border-blue-500', 'hover:shadow-md');
                    } else {
                        btn.disabled = true;
                        btn.classList.add('opacity-50', 'cursor-not-allowed');
                        btn.classList.remove('hover:border-blue-500', 'hover:shadow-md');
                    }
                });
            }

            inputField.addEventListener('input', updateState);

            // Initialize
            updateState();
        });
    </script>
</body>

</html>