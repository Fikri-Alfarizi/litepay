@extends('layouts.mobile')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Header -->
    <div class="bg-white shadow-sm px-6 py-4 flex items-center gap-4 sticky top-0 z-50">
        <a href="{{ route('store.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <h1 class="text-lg font-bold">Payment</h1>
    </div>

    <div class="p-6">
        <!-- Timer -->
        <div class="bg-orange-50 text-orange-600 px-4 py-3 rounded-xl mb-6 flex justify-between items-center text-sm font-medium">
            <span>Complete payment in</span>
            <span id="countdown">23:59:59</span>
        </div>

        <!-- Amount -->
        <div class="bg-white p-6 rounded-2xl shadow-sm mb-6 text-center">
            <p class="text-gray-500 text-sm mb-1">Total Payment</p>
            <h2 class="text-3xl font-bold text-gray-800">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</h2>
            <div class="mt-4 flex justify-between text-sm text-gray-500 border-t pt-4">
                <span>Order ID</span>
                <span class="font-mono text-gray-700">{{ $transaction->invoice_id }}</span>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="space-y-4 mb-24">
            <h3 class="font-bold text-gray-800 px-1">Payment Method</h3>
            
            <!-- LitePay Balance -->
            <label class="block bg-white p-4 rounded-2xl shadow-sm cursor-pointer border-2 has-[:checked]:border-blue-500 transition relative overflow-hidden">
                <input type="radio" name="payment_method" value="balance" class="peer hidden" checked onchange="togglePaymentMethod('balance')">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800">LitePay Balance</p>
                        @auth
                            <p class="text-sm {{ Auth::user()->balance >= $transaction->amount ? 'text-green-600' : 'text-red-500' }}">
                                Balance: Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}
                            </p>
                        @else
                            <p class="text-sm text-gray-500">Login to use balance</p>
                        @endauth
                    </div>
                </div>
                <div class="absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </label>

            <!-- Linked Accounts -->
            @foreach($linkedAccounts as $account)
            <label class="block bg-white p-4 rounded-2xl shadow-sm cursor-pointer border-2 has-[:checked]:border-blue-500 transition relative overflow-hidden">
                <input type="radio" name="payment_method" value="{{ $account->provider }}" class="peer hidden" onchange="togglePaymentMethod('{{ $account->provider }}')">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center font-bold text-xs uppercase">
                        {{ $account->provider }}
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800 capitalize">{{ $account->provider }}</p>
                        <p class="text-sm text-gray-500">{{ $account->account_number }}</p>
                    </div>
                </div>
                <div class="absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </label>
            @endforeach

            <!-- QRIS -->
            <label class="block bg-white p-4 rounded-2xl shadow-sm cursor-pointer border-2 has-[:checked]:border-blue-500 transition relative">
                <input type="radio" name="payment_method" value="qris" class="peer hidden" onchange="togglePaymentMethod('qris')">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                         <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800">QRIS</p>
                        <p class="text-sm text-gray-500">Scan with any e-wallet</p>
                    </div>
                </div>
                 <!-- Selection Indicator -->
                <div class="absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                
                <!-- QR details (hidden by default) -->
                <!-- QR details (Moved to Bottom Sheet) -->
            </label>

            <!-- Virtual Accounts (Mock) -->
            <label class="block bg-white p-4 rounded-2xl shadow-sm cursor-pointer border-2 has-[:checked]:border-blue-500 transition relative">
                <input type="radio" name="payment_method" value="va" class="peer hidden" onchange="togglePaymentMethod('va')">
                <div class="flex items-center gap-4">
                     <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                         <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800">Virtual Account</p>
                        <p class="text-sm text-gray-500">BCA, Mandiri, BRI, BNI</p>
                    </div>
                </div>
                 <!-- Selection Indicator -->
                <div class="absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <!-- VA Details -->
                <div id="va-details" class="hidden mt-4 pt-4 border-t">
                     <div class="bg-gray-50 p-3 rounded-lg flex justify-between items-center mb-2">
                        <span class="font-bold text-gray-700">BCA</span>
                        <span class="font-mono text-sm">8271{{ rand(10000000, 99999999) }}</span>
                    </div>
                </div>
            </label>
        </div>

        <!-- Order Details -->
        <div class="bg-white p-6 rounded-2xl shadow-sm mb-6">
            <h3 class="font-bold text-gray-800 mb-4">Order Details</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Product</span>
                    <span class="font-medium text-right">{{ $transaction->product_name ?? 'Digital Product' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Destination</span>
                    <span class="font-medium">{{ $transaction->destination_number }}</span>
                </div>
                <hr class="border-dashed border-gray-200">
                <div class="flex justify-between">
                    <span class="text-gray-500">Price</span>
                    <span>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Admin Fee</span>
                    <span>Rp {{ number_format($transaction->fee, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tax (11%)</span>
                    <span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-gray-800 pt-2 border-t mt-2">
                    <span>Total</span>
                    <span>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        @auth
            @if(!Auth::user()->pin)
                <div class="bg-red-50 border border-red-100 rounded-2xl p-4 mb-6">
                    <div class="flex gap-3">
                        <div class="bg-red-100 p-2 rounded-full h-fit text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-red-800 text-sm">PIN Belum Disetel</p>
                            <p class="text-xs text-red-600 mb-3">Kamu harus set PIN dulu sebelum bisa bertransaksi demi keamanan akunmu.</p>
                            <a href="{{ route('customer.profile') }}" class="inline-block bg-red-600 text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-red-700 transition">
                                Set PIN Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endauth

        <button onclick="processPayment()" id="pay-btn" 
            class="w-full {{ auth()->check() && !auth()->user()->pin ? 'bg-gray-300 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700' }} text-white font-bold py-4 rounded-xl shadow-lg transition mb-4"
            {{ auth()->check() && !auth()->user()->pin ? 'disabled' : '' }}>
            {{ auth()->check() && !auth()->user()->pin ? 'PIN Belum Disetel' : 'Pay Now' }}
        </button>
        
        <a href="{{ route('checkout.cancel', $transaction->reference_id) }}" class="block text-center text-gray-500 font-medium text-sm">Cancel Transaction</a>
    </div>
</div>

    <!-- PIN Modal -->
    <div id="pin-modal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-end sm:items-center justify-center">
        <div class="bg-white w-full sm:w-80 rounded-t-2xl sm:rounded-2xl p-6 relative">
            <h3 class="font-bold text-lg mb-4 text-center">Enter PIN</h3>
            <p class="text-sm text-gray-500 text-center mb-6">Please enter your 6-digit PIN to confirm payment.</p>
            
            <div class="flex justify-center gap-2 mb-4">
                <input type="password" id="pin-input" maxlength="6" class="w-full text-center text-3xl tracking-[1em] border-b-2 border-gray-200 focus:border-blue-500 focus:outline-none py-2" placeholder="••••••">
            </div>

            <div id="pin-error" class="hidden text-red-500 text-xs text-center mb-4 font-bold"></div>

            <button onclick="submitPaymentWithPin()" id="confirm-pin-btn" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-blue-700 transition">
                Confirm Pay
            </button>
            <button onclick="document.getElementById('pin-modal').classList.add('hidden')" class="w-full text-gray-500 py-3 mt-2">Cancel</button>
        </div>
    </div>

</div>

    <!-- QRIS Bottom Sheet (DANA Style) -->
    <div id="qris-bottom-sheet" class="fixed inset-0 z-50 hidden" style="z-index: 9999;">
        <!-- Backdrop -->
        <div onclick="closeQrisSheet()" class="absolute inset-0 bg-black/60 transition-opacity opacity-0" id="qris-backdrop"></div>
        
        <!-- Sheet -->
        <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl transform translate-y-full transition-transform duration-300 ease-out flex flex-col max-h-[85vh]" id="qris-sheet-content">
            <!-- Handle Bar -->
            <div class="w-full flex justify-center pt-3 pb-2" onclick="closeQrisSheet()">
                <div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
            </div>

            <!-- Header -->
            <div class="px-6 pb-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-lg text-gray-800">QRIS Payment</h3>
                <button onclick="closeQrisSheet()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-6 overflow-y-auto flex-1 flex flex-col items-center">
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6 w-full max-w-xs mx-auto relative group">
                    <!-- QR Code -->
                    <div class="aspect-square bg-white rounded-xl overflow-hidden flex items-center justify-center mb-2">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode(route('gateway.simulator.show', $transaction->reference_id)) }}" 
                             alt="QR Code" 
                             class="w-full h-full object-contain mix-blend-multiply">
                    </div>
                    
                    <!-- Logo Overlay (Optional decoration) -->
                    <div class="absolute inset-x-0 bottom-6 flex justify-center pointer-events-none">
                         <div class="bg-white px-3 py-1 rounded-full shadow-sm border border-gray-100 flex items-center gap-1.5">
                             <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                             <span class="text-xs font-bold text-gray-700">QRIS</span>
                         </div>
                    </div>
                </div>

                <p class="text-center text-gray-800 font-bold text-lg mb-1">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                <p class="text-center text-gray-500 text-sm mb-6">{{ $transaction->merchant->name }}</p>

                <a href="{{ route('gateway.simulator.show', $transaction->reference_id) }}" target="_blank" 
                   class="w-full bg-blue-50 text-blue-600 font-bold py-3 rounded-xl hover:bg-blue-100 transition flex items-center justify-center gap-2 mb-4">
                    Open Simulator
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
                
                <div class="w-full bg-yellow-50 p-3 rounded-xl border border-yellow-100">
                     <p class="text-xs text-yellow-700 text-center">
                        Scan this QR code with any supported e-wallet or banking app (DANA, OVO, GoPay, etc).
                    </p>
                </div>
            </div>
        </div>
    </div>

<script>
    let selectedMethod = 'balance';

    function togglePaymentMethod(method) {
        selectedMethod = method;
        
        // Hide all details first
        if(document.getElementById('va-details')) document.getElementById('va-details').classList.add('hidden');

        // Show details and update button text
        const btn = document.getElementById('pay-btn');
        if (method === 'qris') {
            openQrisSheet();
            btn.innerText = 'Pay using QRIS';
        } else if (method === 'va') {
            if(document.getElementById('va-details')) document.getElementById('va-details').classList.remove('hidden');
            btn.innerText = 'Run Simulation (VA)';
        } else {
            // Balance or Linked Account
            btn.innerText = 'Pay Now (Rp {{ number_format($transaction->amount, 0, ',', '.') }})';
        }
    }

    function processPayment() {
        // If interactive method (balance/linked), show PIN modal
        if (selectedMethod === 'balance' || ['dana', 'ovo', 'gopay', 'shopeepay'].includes(selectedMethod)) {
            document.getElementById('pin-modal').classList.remove('hidden');
            document.getElementById('pin-input').value = '';
            document.getElementById('pin-input').focus();
            return;
        }

        // External methods (QRIS/VA) - Use Simulator
        const btn = document.getElementById('pay-btn');
        btn.disabled = true;
        btn.innerText = 'Processing...';
        
        window.open("{{ route('gateway.simulator.show', $transaction->reference_id) }}", "_blank");
        btn.innerText = 'Waiting for Payment...';
    }

    function submitPaymentWithPin() {
        const pin = document.getElementById('pin-input').value;
        if (pin.length !== 6) {
            alert('Please enter a 6-digit PIN');
            return;
        }

        const btn = document.getElementById('confirm-pin-btn');
        btn.disabled = true;
        btn.innerText = 'Verifying...';

        const errorEl = document.getElementById('pin-error');
        errorEl.classList.add('hidden');
        errorEl.innerText = '';

        fetch("{{ route('checkout.pay', $transaction->reference_id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                pin: pin,
                payment_method: selectedMethod
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.message === 'Payment Successful') {
                window.location.href = "{{ route('checkout.success', $transaction->reference_id) }}";
            } else {
                errorEl.innerText = data.message;
                errorEl.classList.remove('hidden');
                btn.disabled = false;
                btn.innerText = 'Confirm Pay';
                
                document.getElementById('pin-input').value = '';
                document.getElementById('pin-input').focus();
            }
        })
        .catch(err => {
             errorEl.innerText = 'Gagal memproses pembayaran. Silakan coba lagi.';
             errorEl.classList.remove('hidden');
             btn.disabled = false;
             btn.innerText = 'Confirm Pay';
        });
    }

    // Polling status
    setInterval(() => {
        fetch("{{ route('checkout.status', $transaction->reference_id) }}")
            .then(res => res.json())
            .then(data => {
                if (data.status === 'SUCCESS') {
                    window.location.href = "{{ route('checkout.success', $transaction->reference_id) }}";
                }
            });
    }, 3000);

    // Bottom Sheet Logic
    function openQrisSheet() {
        const sheet = document.getElementById('qris-bottom-sheet');
        const backdrop = document.getElementById('qris-backdrop');
        const content = document.getElementById('qris-sheet-content');
        
        // Show container
        sheet.classList.remove('hidden');
        
        // Animate in
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            content.classList.remove('translate-y-full');
        }, 10);
    }

    function closeQrisSheet() {
        const sheet = document.getElementById('qris-bottom-sheet');
        const backdrop = document.getElementById('qris-backdrop');
        const content = document.getElementById('qris-sheet-content');

        // Animate out
        backdrop.classList.add('opacity-0');
        content.classList.add('translate-y-full');

        // Hide container after animation
        setTimeout(() => {
            sheet.classList.add('hidden');
            // Reset selection to default or keep it? User might want to try again.
            // keeping it is fine.
        }, 300);
    }
</script>
@endsection