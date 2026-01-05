@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Promo & Vouchers</h1>
            <p class="text-gray-500 mt-1">Manage marketing campaigns.</p>
        </div>
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow transition flex items-center space-x-2 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span>Create Promo</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Active Promo 1 -->
        <div class="bg-white rounded-xl shadow overflow-hidden group hover:shadow-lg transition">
            <div class="h-32 bg-gradient-to-r from-purple-500 to-indigo-600 p-6 flex items-center justify-center text-white relative overflow-hidden">
                <svg class="w-24 h-24 absolute -right-6 -bottom-6 opacity-20 transform rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12a2 2 0 110 4h14a2 2 0 110-4"></path></svg>
                <div class="text-center relative z-10">
                    <h3 class="text-2xl font-bold">LITEPAY50</h3>
                    <p class="text-sm opacity-90">50% Off Transaction Fees</p>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-bold">Active</span>
                     <span class="text-sm text-gray-500">Used: 1,234 times</span>
                </div>
                 <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 45%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 mb-6">
                    <span>Starts: 01 Jan 2026</span>
                    <span>Ends: 31 Dec 2026</span>
                </div>
                <div class="flex space-x-2">
                    <button class="flex-1 border border-gray-300 rounded py-2 text-sm font-medium hover:bg-gray-50">Edit</button>
                    <button class="flex-1 border border-red-300 text-red-600 rounded py-2 text-sm font-medium hover:bg-red-50">End</button>
                </div>
            </div>
        </div>

        <!-- Active Promo 2 -->
         <div class="bg-white rounded-xl shadow overflow-hidden group hover:shadow-lg transition">
            <div class="h-32 bg-gradient-to-r from-orange-500 to-red-600 p-6 flex items-center justify-center text-white relative overflow-hidden">
                 <svg class="w-24 h-24 absolute -left-6 -top-6 opacity-20 transform -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12a2 2 0 110 4h14a2 2 0 110-4"></path></svg>
                <div class="text-center relative z-10">
                    <h3 class="text-2xl font-bold">NEWUSER</h3>
                    <p class="text-sm opacity-90">Free First Month</p>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-bold">Active</span>
                     <span class="text-sm text-gray-500">Used: 89 times</span>
                </div>
                 <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                    <div class="bg-orange-500 h-2 rounded-full" style="width: 15%"></div>
                </div>
                 <div class="flex justify-between text-xs text-gray-500 mb-6">
                    <span>Starts: 05 Jan 2026</span>
                    <span>Ends: 05 Feb 2026</span>
                </div>
                <div class="flex space-x-2">
                    <button class="flex-1 border border-gray-300 rounded py-2 text-sm font-medium hover:bg-gray-50">Edit</button>
                    <button class="flex-1 border border-red-300 text-red-600 rounded py-2 text-sm font-medium hover:bg-red-50">End</button>
                </div>
            </div>
        </div>

        <!-- Create New Card -->
         <button class="border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center p-6 text-gray-400 hover:text-indigo-500 hover:border-indigo-500 transition h-full min-h-[300px]">
            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span class="font-bold text-lg">Create New Campaign</span>
        </button>
    </div>
@endsection
