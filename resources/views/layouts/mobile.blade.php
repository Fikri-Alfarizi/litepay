<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'LitePay' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="max-w-md mx-auto bg-gray-50 min-h-screen shadow-2xl relative overflow-hidden pb-24">

        @yield('content')

        <!-- QR Scanner Overlay (Bottom Sheet) -->
        <div id="scanner-container"
            class="fixed inset-x-0 bottom-0 top-0 z-[100] hidden flex flex-col justify-end overflow-hidden max-w-md mx-auto">
            <!-- Backdrop -->
            <div id="scanner-backdrop" onclick="toggleScanner(false)"
                class="absolute inset-0 bg-black/60 transition-opacity opacity-0 duration-300"></div>

            <!-- Scanner Sheet -->
            <div id="scanner-sheet"
                class="relative w-full bg-white rounded-t-[2rem] shadow-2xl transform translate-y-full transition-transform duration-300 ease-out z-[110] flex flex-col h-[85%]">

                <!-- DANA HEADER -->
                <div class="flex justify-between items-center px-6 py-4 bg-white border-b border-gray-50 flex-shrink-0">
                    <!-- Left: DANA Protection -->
                    <div class="flex items-center gap-2 opacity-90">
                        <svg class="w-5 h-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            <path d="M9 12l2 2 4-4" />
                        </svg>
                        <div class="flex flex-col leading-none">
                            <span class="text-[9px] font-bold text-gray-500">DANA</span>
                            <span class="text-[9px] font-bold text-gray-500">PROTECTION</span>
                        </div>
                    </div>

                    <!-- Center: PAY -->
                    <div class="flex items-center gap-1.5">
                        <div
                            class="w-7 h-7 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xs p-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M21 4H3a2 2 0 00-2 2v12a2 2 0 002 2h18a2 2 0 002-2V6a2 2 0 00-2-2zM5 15h3a1 1 0 011 1v1a1 1 0 01-1 1H5a1 1 0 01-1-1v-1a1 1 0 011-1zm3-6H5a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 011 1v1a1 1 0 01-1 1z" />
                            </svg>
                        </div>
                        <span class="font-bold text-blue-500 text-base">PAY</span>
                    </div>

                    <!-- Right Spacer -->
                    <button onclick="toggleScanner(false)" class="p-1">
                        <span class="text-blue-500 font-bold text-[10px]">Help</span>
                    </button>
                </div>

                <!-- Scanner Viewfinder Container -->
                <div class="flex-1 bg-white relative px-4 flex flex-col items-center justify-start pt-6">
                    <!-- Viewfinder -->
                    <div
                        class="relative w-full max-w-[260px] aspect-[3/4] rounded-[2rem] overflow-hidden bg-black shadow-inner border-[3px] border-white ring-1 ring-gray-100">
                        <div id="reader" class="w-full h-full object-cover"></div>
                        <style>
                            #reader video {
                                object-fit: cover;
                                width: 100% !important;
                                height: 100% !important;
                                border-radius: 2rem;
                            }
                        </style>

                        <!-- Top Icons Overlay -->
                        <div class="absolute top-4 left-4 z-10">
                            <button
                                class="bg-black/20 hover:bg-black/40 w-9 h-9 rounded-full text-white backdrop-blur-md flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        <div class="absolute top-4 right-4 z-10">
                            <button
                                class="bg-black/20 hover:bg-black/40 w-9 h-9 rounded-full text-white backdrop-blur-md flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Corner Markers -->
                        <div class="absolute inset-5 border-[2px] border-white/40 rounded-2xl pointer-events-none">
                        </div>

                        <!-- Animated Scan Line -->
                        <div class="absolute inset-0 pointer-events-none">
                            <div
                                class="w-full h-0.5 bg-blue-400/80 absolute top-0 animate-[scan_2s_ease-in-out_infinite] shadow-[0_0_20px_rgba(96,165,250,0.6)]">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Action Bar -->
                <div
                    class="bg-white px-6 pb-6 pt-2 flex justify-between items-end text-xs font-medium text-gray-500 w-full flex-shrink-0">
                    <!-- Pindai -->
                    <button class="flex flex-col items-center gap-2 group w-16">
                        <div
                            class="w-12 h-12 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-700 group-hover:bg-gray-50 transition shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-semibold">Pindai</span>
                    </button>

                    <!-- Tutup -->
                    <button onclick="toggleScanner(false)" class="flex flex-col items-center gap-2 group w-16">
                        <div
                            class="w-12 h-12 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-700 group-hover:bg-gray-50 transition shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-semibold">Tutup</span>
                    </button>

                    <!-- Tambah Kartu -->
                    <button class="flex flex-col items-center gap-2 group w-16">
                        <div
                            class="w-12 h-12 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-700 group-hover:bg-gray-50 transition shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-semibold text-center leading-tight">Tambah Kartu</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Bottom Navigation -->
        @if(!isset($hideBottomNav) || !$hideBottomNav)
            <div
                class="fixed bottom-0 w-full max-w-md left-1/2 -translate-x-1/2 bg-white border-t border-gray-200 py-2 px-4 flex justify-between items-end text-[10px] text-gray-400 z-50 rounded-t-2xl shadow-[0_-5px_10px_rgba(0,0,0,0.02)]">

                <!-- Home -->
                <a href="{{ route('store.index') }}"
                    class="flex flex-col items-center justify-center w-14 group {{ request()->routeIs('store.index') ? 'text-blue-600' : 'hover:text-blue-500' }}">
                    <div
                        class="mb-1 p-1 rounded-xl {{ request()->routeIs('store.index') ? 'bg-blue-50' : 'group-hover:bg-gray-50' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <span class="font-medium">Home</span>
                </a>

                <!-- History -->
                <a href="{{ route('customer.history') }}"
                    class="flex flex-col items-center justify-center w-14 group {{ request()->routeIs('customer.history') ? 'text-blue-600' : 'hover:text-blue-500' }}">
                    <div
                        class="mb-1 p-1 rounded-xl {{ request()->routeIs('customer.history') ? 'bg-blue-50' : 'group-hover:bg-gray-50' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <span class="font-medium">History</span>
                </a>

                <!-- Scan (Center) -->
                <button onclick="toggleScanner(true)"
                    class="relative -top-6 flex flex-col items-center justify-center group outline-none">
                    <div
                        class="w-14 h-14 bg-blue-600 text-white rounded-full shadow-lg shadow-blue-300 flex items-center justify-center border-4 border-white transition-transform active:scale-95 hover:scale-105">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-blue-600 font-bold text-[10px] mt-1">Scan</span>
                </button>

                <!-- Inbox -->
                <a href="{{ route('customer.inbox') }}"
                    class="flex flex-col items-center justify-center w-14 group {{ request()->routeIs('customer.inbox') ? 'text-blue-600' : 'hover:text-blue-500' }}">
                    <div
                        class="mb-1 p-1 rounded-xl {{ request()->routeIs('customer.inbox') ? 'bg-blue-50' : 'group-hover:bg-gray-50' }} relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <!-- Notification Badge -->
                        <span id="inbox-badge"
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full hidden">0</span>
                    </div>
                    <span class="font-medium">Inbox</span>
                </a>

                <!-- Profile -->
                <a href="{{ route('customer.profile') }}"
                    class="flex flex-col items-center justify-center w-14 group {{ request()->routeIs('customer.profile') ? 'text-blue-600' : 'hover:text-blue-500' }}">
                    <div
                        class="mb-1 p-1 rounded-xl {{ request()->routeIs('customer.profile') ? 'bg-blue-50' : 'group-hover:bg-gray-50' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Profile</span>
                </a>

            </div>
        @endif
    </div>

    <style>
        @keyframes scan {

            0%,
            100% {
                top: 0%;
                opacity: 0;
            }

            50% {
                top: 100%;
                opacity: 1;
            }
        }
    </style>

    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
    <script>
        let html5QrCode = null;

        // Debug Logger
        // Debug Logger (disabled for production)
        function logDebug(msg) {
            console.log(msg); // Keep console log for dev tools
        }

        function toggleScanner(show) {
            const container = document.getElementById('scanner-container');
            const backdrop = document.getElementById('scanner-backdrop');
            const sheet = document.getElementById('scanner-sheet');

            if (show) {
                container.classList.remove('hidden');



                logDebug('Opening Scanner...');

                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    sheet.classList.remove('translate-y-full');
                }, 10);

                setTimeout(() => {
                    ensureLibraryLoadedAndStart();
                }, 500);

            } else {
                backdrop.classList.add('opacity-0');
                sheet.classList.add('translate-y-full');

                if (html5QrCode) {
                    html5QrCode.stop().then(() => {
                        html5QrCode.clear();
                        html5QrCode = null;
                        document.getElementById('reader').innerHTML = '';
                    }).catch(err => logDebug('Stop Error: ' + err));
                }

                setTimeout(() => {
                    container.classList.add('hidden');

                }, 300);
            }
        }

        function ensureLibraryLoadedAndStart(attempts = 0) {
            if (typeof Html5Qrcode !== 'undefined') {
                startScannerLogic();
            } else {
                if (attempts < 10) {
                    logDebug(`Library not loaded, retrying (${attempts + 1})...`);
                    setTimeout(() => ensureLibraryLoadedAndStart(attempts + 1), 500);
                } else {
                    logDebug('CRITICAL: Library failed to load.');
                    alert('Gagal memuat sistem scanner. Periksa koneksi internet.');
                }
            }
        }

        function startScannerLogic() {
            logDebug('Initializing html5-qrcode...');

            try {
                if (html5QrCode === null) {
                    html5QrCode = new Html5Qrcode("reader");
                }
            } catch (e) {
                logDebug('Init Error: ' + e);
            }

            document.getElementById('reader').innerHTML = '<div class="text-white text-center pt-10">Starting Camera...</div>';

            // Config for better detection
            const config = {
                fps: 20, // Check more often
                aspectRatio: 1.0
            };

            // Explicitly verify getUserMedia first
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                logDebug('Error: getUserMedia not supported (HTTPS?)');
                alert('Browser tidak mendukung kamera atau tidak secure (HTTPS missing).');
                return;
            }

            logDebug('Requesting Camera Permission...');

            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    logDebug('Permission GRANTED.');
                    // Stop this test stream to let library take over
                    stream.getTracks().forEach(track => track.stop());

                    // Start Library
                    logDebug('Starting Library Scan...');
                    html5QrCode.start(
                        { facingMode: "user" }, // Force user for laptop
                        config,
                        (decodedText, decodedResult) => {
                            logDebug('FOUND RAW: ' + decodedText);
                            let cleanText = decodedText.trim();

                            if (cleanText.toLowerCase().startsWith('http')) {
                                logDebug('Opening in new tab: ' + cleanText);
                                window.open(cleanText, '_blank');
                                toggleScanner(false);
                            } else {
                                alert("QR Detected: " + cleanText);
                            }
                        },
                        (errorMessage) => { }
                    ).then(() => {
                        logDebug('Scanner RUNNING.');
                    }).catch(err => {
                        logDebug('Start Error: ' + err);

                        // Retry with any camera
                        logDebug('Retrying with any camera...');
                        html5QrCode.start({}, config, () => { }, () => { })
                            .then(() => logDebug('Retry Success.'))
                            .catch(e => logDebug('Retry Failed: ' + e));
                    });
                })
                .catch(err => {
                    logDebug('Permission DENIED: ' + err);
                    alert('Gagal akses kamera: ' + err);
                });
        }

        function checkUnreadInbox() {
            fetch("{{ route('customer.inbox.unread') }}")
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('inbox-badge');
                    if (data.unread_count > 0) {
                        badge.innerText = data.unread_count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                })
                .catch(err => console.error('Error fetching unread count:', err));
        }

        if ({{ Auth::check() ? 'true' : 'false' }}) {
            checkUnreadInbox();
            setInterval(checkUnreadInbox, 5000);
        }
    </script>
    @stack('scripts')
</body>

</html>