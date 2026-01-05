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
                <input type="tel" id="identifierInput"
                    class="w-full text-xl font-semibold outline-none py-2 placeholder-gray-300" placeholder="08..."
                    autofocus>
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

        <!-- Single Form for Submission -->
        <form id="purchaseForm" action="{{ route('store.purchase') }}" method="POST">
            @csrf
            <input type="hidden" name="identifier" id="hiddenIdentifier" value="">
            <input type="hidden" name="product_name" id="hiddenProductName" value="">
            <input type="hidden" name="amount" id="hiddenAmount" value="">

            <div class="grid grid-cols-2 gap-4 mb-24">
                @foreach($products as $product)
                    <div onclick="selectProduct(this, '{{ $product['name'] }}', '{{ $product['amount'] }}')"
                        class="product-card bg-white p-4 rounded-xl shadow-sm border-2 border-transparent cursor-pointer transition hover:shadow-md relative group">
                        <div class="flex justify-between items-start mb-2">
                            <span
                                class="text-xs font-bold bg-blue-100 text-blue-600 px-2 py-1 rounded">{{ $categoryName }}</span>
                        </div>
                        <div class="font-bold text-gray-800 mb-1">{{ $product['name'] }}</div>
                        <div class="text-orange-600 font-bold text-lg">Rp
                            {{ number_format($product['amount'], 0, ',', '.') }}</div>
                        <p class="text-xs text-gray-400 mt-2">{{ $product['description'] }}</p>

                        <!-- Checkmark Icon for Selected State -->
                        <div class="absolute top-2 right-2 hidden check-icon">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Sticky Bottom Action Bar -->
            <div id="bottomBar"
                class="fixed bottom-0 left-0 right-0 bg-white border-t p-4 shadow-lg transform translate-y-full transition-transform duration-300 z-50">
                <div class="max-w-md mx-auto flex justify-between items-center">
                    <div>
                        <div class="text-xs text-gray-500">Total Payment</div>
                        <div class="text-lg font-bold text-gray-800" id="totalPrice">Rp 0</div>
                    </div>
                    <button type="submit" id="continueBtn" disabled
                        class="bg-blue-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition">
                        Continue
                    </button>
                </div>
            </div>
        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputField = document.querySelector('#identifierInput');
            const hiddenIdentifier = document.querySelector('#hiddenIdentifier');
            const hiddenProduct = document.querySelector('#hiddenProductName');
            const hiddenAmount = document.querySelector('#hiddenAmount');
            const bottomBar = document.querySelector('#bottomBar');
            const totalPriceEl = document.querySelector('#totalPrice');
            const continueBtn = document.querySelector('#continueBtn');
            const cards = document.querySelectorAll('.product-card');

            let selectedProduct = null;

            // Expose selectProduct to global scope
            window.selectProduct = function (element, name, amount) {
                // Deselect all
                cards.forEach(card => {
                    card.classList.remove('border-blue-500', 'bg-blue-50');
                    card.querySelector('.check-icon').classList.add('hidden');
                });

                // Select clicked
                element.classList.add('border-blue-500', 'bg-blue-50');
                element.querySelector('.check-icon').classList.remove('hidden');

                // Update Data
                selectedProduct = { name, amount };
                hiddenProduct.value = name;
                hiddenAmount.value = amount;

                // Update UI
                totalPriceEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);

                // Show Bottom Bar
                bottomBar.classList.remove('translate-y-full');

                validateForm();
            };

            function validateForm() {
                const identifierValues = inputField.value.trim();
                const isIdentifierValid = identifierValues.length >= 8;
                const isProductSelected = selectedProduct !== null;

                hiddenIdentifier.value = identifierValues;

                if (isIdentifierValid && isProductSelected) {
                    continueBtn.disabled = false;
                } else {
                    continueBtn.disabled = true;
                }
            }

            inputField.addEventListener('input', validateForm);
        });
    </script>
</body>

</html>