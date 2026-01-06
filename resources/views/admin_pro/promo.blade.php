@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">Promo & Vouchers</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Manage marketing campaigns.</p>
        </div>
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg shadow-sm transition flex items-center space-x-2 text-xs font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span>Create Promo</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse ($promos as $promo)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden group hover:shadow-md transition">
            <div class="h-24 bg-gradient-to-r from-purple-500 to-indigo-600 p-4 flex items-center justify-center text-white relative overflow-hidden">
                <svg class="w-20 h-20 absolute -right-4 -bottom-4 opacity-20 transform rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12a2 2 0 110 4h14a2 2 0 110-4"></path></svg>
                <div class="text-center relative z-10">
                    <h3 class="text-xl font-bold">{{ $promo->code }}</h3>
                    <p class="text-xs opacity-90">{{ $promo->description }}</p>
                </div>
            </div>
            <div class="p-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 text-[10px] px-1.5 py-0.5 rounded font-bold">{{ ucfirst($promo->status) }}</span>
                     <span class="text-xs text-gray-500 dark:text-gray-400">Used: {{ number_format($promo->usage_count) }} times</span>
                </div>
                 <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mb-3">
                    <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ min(100, $promo->usage_count) }}%"></div>
                </div>
                <div class="flex justify-between text-[10px] text-gray-500 dark:text-gray-400 mb-4">
                    <span>Starts: {{ $promo->starts_at?->format('d M Y') ?? 'N/A' }}</span>
                    <span>Ends: {{ $promo->ends_at?->format('d M Y') ?? 'N/A' }}</span>
                </div>
                <div class="flex space-x-2">
                    <button class="flex-1 border border-gray-300 dark:border-gray-600 rounded py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Edit</button>
                    <button class="flex-1 border border-red-300 dark:border-red-800 text-red-600 dark:text-red-400 rounded py-1.5 text-xs font-medium hover:bg-red-50 dark:hover:bg-red-900/20">End</button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-1 md:col-span-3 text-center py-8 text-gray-500 dark:text-gray-400">
            No promos found.
        </div>
        @endforelse

        <!-- Create New Card -->
         <button class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg flex flex-col items-center justify-center p-4 text-gray-400 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-500 dark:hover:border-indigo-400 transition h-full min-h-[250px]">
            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span class="font-bold text-sm">Create New Campaign</span>
        </button>
    </div>
@endsection
