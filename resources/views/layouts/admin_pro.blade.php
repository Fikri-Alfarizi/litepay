<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Pro' }} - LitePay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inte:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-900 text-white flex flex-col shadow-xl">
            <div class="h-16 flex items-center justify-center border-b border-indigo-800">
                <h1 class="text-2xl font-bold tracking-wider">LITEPAY<span class="text-indigo-400">PRO</span></h1>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
                <p class="text-xs text-indigo-400 font-semibold uppercase tracking-wider mb-2">Main Menu</p>
                
                <a href="{{ route('admin_pro.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin_pro.dashboard') ? 'bg-indigo-700 text-white shadow-md' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin_pro.merchants') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin_pro.merchants') ? 'bg-indigo-700 text-white shadow-md' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="font-medium">Merchants</span>
                </a>

                <a href="{{ route('admin_pro.transactions') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin_pro.transactions') ? 'bg-indigo-700 text-white shadow-md' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">Transactions</span>
                </a>

                <a href="{{ route('admin_pro.balance') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin_pro.balance') ? 'bg-indigo-700 text-white shadow-md' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    <span class="font-medium">Balance</span>
                </a>

                <a href="{{ route('admin_pro.promo') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin_pro.promo') ? 'bg-indigo-700 text-white shadow-md' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    <span class="font-medium">Promo</span>
                </a>

                <div x-data="{ open: {{ request()->routeIs('admin_pro.account.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition text-indigo-200 hover:bg-indigo-800 hover:text-white">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="font-medium">Account</span>
                        </div>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-transition.origin.top class="pl-12 pr-2 space-y-1 mt-1">
                        <a href="{{ route('admin_pro.account.profile') }}" class="block py-2 text-sm {{ request()->routeIs('admin_pro.account.profile') ? 'text-white font-semibold' : 'text-indigo-300 hover:text-white' }}">Profile</a>
                        <a href="{{ route('admin_pro.account.ip_whitelist') }}" class="block py-2 text-sm {{ request()->routeIs('admin_pro.account.ip_whitelist') ? 'text-white font-semibold' : 'text-indigo-300 hover:text-white' }}">IP Whitelist</a>
                        <a href="{{ route('admin_pro.account.users') }}" class="block py-2 text-sm {{ request()->routeIs('admin_pro.account.users') ? 'text-white font-semibold' : 'text-indigo-300 hover:text-white' }}">Manage Users</a>
                        <a href="{{ route('admin_pro.account.activity') }}" class="block py-2 text-sm {{ request()->routeIs('admin_pro.account.activity') ? 'text-white font-semibold' : 'text-indigo-300 hover:text-white' }}">Activity Log</a>
                    </div>
                </div>

                <p class="text-xs text-indigo-400 font-semibold uppercase tracking-wider mb-2 mt-6">Finance</p>

                <a href="{{ route('admin_pro.settlements') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin_pro.settlements') ? 'bg-indigo-700 text-white shadow-md' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">Settlements</span>
                </a>

                <p class="text-xs text-indigo-400 font-semibold uppercase tracking-wider mb-2 mt-6">Security</p>

                <a href="{{ route('admin_pro.risk') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin_pro.risk') ? 'bg-indigo-700 text-white shadow-md' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span class="font-medium">Risk Management</span>
                </a>

                <p class="text-xs text-indigo-400 font-semibold uppercase tracking-wider mb-2 mt-6">System</p>

                <a href="{{ route('admin_pro.api') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin_pro.api') ? 'bg-indigo-700 text-white shadow-md' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    <span class="font-medium">API Management</span>
                </a>

                <a href="{{ route('admin_pro.callbacks') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin_pro.callbacks') ? 'bg-indigo-700 text-white shadow-md' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    <span class="font-medium">Callbacks</span>
                </a>

                <p class="text-xs text-indigo-400 font-semibold uppercase tracking-wider mb-2 mt-6">System</p>
                
                <a href="{{ route('admin_pro.settings') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin_pro.settings') ? 'bg-indigo-700 text-white shadow-md' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="font-medium">Settings</span>
                </a>
            </nav>

            <div class="p-4 border-t border-indigo-800">
                 <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 text-indigo-300 hover:text-white w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-y-auto bg-gray-50">
            <!-- Top Navbar -->
            <header class="bg-white shadow h-16 flex items-center justify-between px-8">
                <div class="flex items-center">
                    <div class="relative">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 rounded-full border border-gray-200 focus:outline-none focus:border-indigo-500 w-64 text-sm text-gray-600 transition">
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <button class="relative p-2 text-gray-400 hover:text-indigo-600 transition">
                        <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </button>
                    <div class="flex items-center space-x-2 border-l pl-4">
                        <img src="https://ui-avatars.com/api/?name=Admin+System&background=random" class="w-8 h-8 rounded-full border border-indigo-100">
                        <div class="hidden md:block text-left">
                            <span class="block text-sm font-bold text-gray-700">Administrator</span>
                            <span class="block text-xs text-gray-500">Super Admin</span>
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-8">
                @yield('content')
            </div>
            
             <footer class="mt-auto px-8 py-4 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} LitePay Inc. All rights reserved.
            </footer>
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>
