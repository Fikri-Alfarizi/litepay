@extends('layouts.mobile')

@section('content')
    <!-- Header -->
    <div class="bg-blue-600 text-white rounded-b-[2rem] shadow-lg pb-10 pt-6 px-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 opacity-10">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13 7H7v6h6V7z" />
                <path fill-rule="evenodd"
                    d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2h-2v1a1 1 0 11-2 0v-1H9v1a1 1 0 11-2 0v-1H5a2 2 0 01-2-2v-2H2a1 1 0 110-2h1v-2H2a1 1 0 110-2h1V7a2 2 0 012-2h2V2zM5 7v6h6V7H5z"
                    clip-rule="evenodd" />
            </svg>
        </div>

        <div class="flex justify-between items-center mb-6">
            <div>
                <p class="text-blue-100 text-sm">Welcome back,</p>
                <h1 class="text-2xl font-bold">
                    @auth
                        {{ Auth::user()->name }}
                    @else
                        Guest User
                    @endauth
                </h1>
            </div>
            <div
                class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center border-2 border-blue-400 overflow-hidden">
                @auth
                    <span class="font-bold">{{ substr(Auth::user()->name, 0, 2) }}</span>
                @else
                    <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                @endauth
            </div>
        </div>

        @auth
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20">
                <p class="text-blue-100 text-xs mb-1">LitePay Balance</p>
                <p class="text-3xl font-bold">Rp 0</p>
            </div>
        @else
            <a href="{{ route('customer.login') }}"
                class="block bg-white text-blue-600 text-center font-bold py-3 px-4 rounded-xl shadow-md hover:bg-blue-50 transition">
                Login / Register
            </a>
        @endauth
    </div>

    <!-- Main Menu -->
    <div class="px-6 -mt-8 relative z-10">
        <div class="bg-white rounded-2xl shadow-md p-6 grid grid-cols-4 gap-4 text-center">

            <a href="{{ route('store.category', 'pulsa') }}" class="flex flex-col items-center gap-2 group">
                <div
                    class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700">Pulsa</span>
            </a>

            <a href="{{ route('store.category', 'data') }}" class="flex flex-col items-center gap-2 group">
                <div
                    class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700">Data</span>
            </a>

            <a href="{{ route('store.category', 'pln') }}" class="flex flex-col items-center gap-2 group">
                <div
                    class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700">PLN</span>
            </a>

            <a href="#" class="flex flex-col items-center gap-2 group opacity-50 cursor-not-allowed">
                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700">Games</span>
            </a>
        </div>
    </div>

    <!-- Promo Banner -->
    <div class="px-6 mt-6 pb-20">
        <div
            class="bg-gradient-to-r from-pink-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="font-bold text-lg mb-1">Super Deal!</h3>
                <p class="text-sm opacity-90 mb-3">Get 50% Cashback for new users.</p>
                <button class="bg-white text-purple-600 text-xs font-bold px-4 py-2 rounded-full">Learn More</button>
            </div>
            <div class="absolute -right-6 -bottom-6 opacity-20 transform rotate-12">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 7H7v6h6V7z" />
                    <path fill-rule="evenodd"
                        d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2h-2v1a1 1 0 11-2 0v-1H9v1a1 1 0 11-2 0v-1H5a2 2 0 01-2-2v-2H2a1 1 0 110-2h1v-2H2a1 1 0 110-2h1V7a2 2 0 012-2h2V2zM5 7v6h6V7H5z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>
@endsection