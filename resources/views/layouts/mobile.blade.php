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

        <!-- Bottom Navigation -->
        @if(!isset($hideBottomNav) || !$hideBottomNav)
        <div
            class="fixed bottom-0 w-full max-w-md left-1/2 -translate-x-1/2 bg-white border-t border-gray-200 py-2 px-4 flex justify-between items-end text-[10px] text-gray-400 z-50 rounded-t-2xl shadow-[0_-5px_10px_rgba(0,0,0,0.02)]">
            
            <!-- Home -->
            <a href="{{ route('store.index') }}" class="flex flex-col items-center justify-center w-14 group {{ request()->routeIs('store.index') ? 'text-blue-600' : 'hover:text-blue-500' }}">
                <div class="mb-1 p-1 rounded-xl {{ request()->routeIs('store.index') ? 'bg-blue-50' : 'group-hover:bg-gray-50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <span class="font-medium">Home</span>
            </a>

            <!-- History -->
            <a href="{{ route('customer.history') }}" class="flex flex-col items-center justify-center w-14 group {{ request()->routeIs('customer.history') ? 'text-blue-600' : 'hover:text-blue-500' }}">
                 <div class="mb-1 p-1 rounded-xl {{ request()->routeIs('customer.history') ? 'bg-blue-50' : 'group-hover:bg-gray-50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <span class="font-medium">History</span>
            </a>

            <!-- Scan (Center) -->
            <a href="#" class="relative -top-5 flex flex-col items-center justify-center group">
                <div class="w-14 h-14 bg-blue-600 text-white rounded-full shadow-lg shadow-blue-300 flex items-center justify-center transform group-hover:scale-110 transition border-4 border-white">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 17h.01M8 11h.01M12 12h.01M16 11h.01M3 20h6M3 7h6M16 20h6M16 7h6"></path>
                    </svg>
                </div>
                <span class="text-blue-600 font-bold mt-1">Scan</span>
            </a>

            <!-- Inbox -->
            <a href="#" class="flex flex-col items-center justify-center w-14 group hover:text-blue-500">
                 <div class="mb-1 p-1 rounded-xl group-hover:bg-gray-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="font-medium">Inbox</span>
            </a>

            <!-- Profile -->
            <a href="{{ route('customer.profile') }}" class="flex flex-col items-center justify-center w-14 group {{ request()->routeIs('customer.profile') ? 'text-blue-600' : 'hover:text-blue-500' }}">
                 <div class="mb-1 p-1 rounded-xl {{ request()->routeIs('customer.profile') ? 'bg-blue-50' : 'group-hover:bg-gray-50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <span class="font-medium">Profile</span>
            </a>
            
        </div>
        @endif
    </div>
    @stack('scripts')
</body>

</html>
