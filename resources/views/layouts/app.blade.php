<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Simple CSS for now -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="#" class="font-bold text-xl text-indigo-600">Payment Gateway Lite</a>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-900 hover:text-indigo-600 px-3 py-2">Dashboard</a>
                                <a href="{{ route('admin.merchants.index') }}" class="text-gray-500 hover:text-indigo-600 px-3 py-2">Merchants</a>
                                <a href="{{ route('admin.transactions.index') }}" class="text-gray-500 hover:text-indigo-600 px-3 py-2">Transactions</a>
                            @elseif(auth()->check() && auth()->user()->role === 'merchant')
                                <a href="{{ route('merchant.dashboard') }}" class="text-gray-900 hover:text-indigo-600 px-3 py-2">Dashboard</a>
                                <a href="{{ route('merchant.invoices.index') }}" class="text-gray-500 hover:text-indigo-600 px-3 py-2">Invoices</a>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center">
                        @auth
                            <span class="mr-4 text-gray-600">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900">Logout</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
