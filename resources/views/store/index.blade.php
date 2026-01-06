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

            <!-- Mobile Legends -->
            <a href="{{ route('store.category', 'mobile-legends') }}" class="flex flex-col items-center gap-2 group">
                <div
                    class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700">Mobile Legends</span>
            </a>

            <!-- Free Fire -->
            <a href="{{ route('store.category', 'free-fire') }}" class="flex flex-col items-center gap-2 group">
                <div
                    class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700">Free Fire</span>
            </a>

            <!-- PUBG Mobile -->
            <a href="{{ route('store.category', 'pubg-mobile') }}" class="flex flex-col items-center gap-2 group">
                <div
                    class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"> <!-- Clock/Time logic for 'Survival' -->
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700">PUBG Mobile</span>
            </a>

            <!-- Genshin Impact -->
            <a href="{{ route('store.category', 'genshin-impact') }}" class="flex flex-col items-center gap-2 group">
                <div
                    class="w-12 h-12 bg-pink-100 text-pink-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"> <!-- Star-like -->
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700" style="font-size: 0.65rem; line-height: 1rem;">Genshin Impact</span>
            </a>

            <!-- Valorant -->
            <a href="{{ route('store.category', 'valorant') }}" class="flex flex-col items-center gap-2 group">
                <div
                    class="w-12 h-12 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"> <!-- Desktop/PC -->
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700">Valorant</span>
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