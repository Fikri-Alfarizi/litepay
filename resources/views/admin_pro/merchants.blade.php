@extends('layouts.admin_pro')

@section('content')
    <div x-data="{ openModal: false }" class="relative">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">Merchants Management</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Manage partner accounts and integrations.</p>
            </div>
            <button @click="openModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg shadow-sm transition flex items-center space-x-2 text-xs font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                <span>Add Merchant</span>
            </button>
        </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        <!-- Filters Header -->
        <div class="p-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex flex-wrap gap-3 justify-between items-center">
             <div class="flex space-x-2">
                 <button class="px-2.5 py-1 rounded bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-xs font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">All</button>
                 <button class="px-2.5 py-1 rounded bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-xs font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">Active</button>
                 <button class="px-2.5 py-1 rounded bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-xs font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">Suspended</button>
             </div>
             
             <div class="relative">
                 <form action="{{ route('admin_pro.merchants') }}" method="GET">
                     <input type="text" name="search" value="{{ request('search') }}" placeholder="Search merchant..." class="pl-8 pr-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:ring-indigo-500 focus:border-indigo-500 w-56 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400">
                     <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                 </form>
             </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Merchant Name</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">API Status</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction Vol.</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Last Active</th>
                        <th class="px-4 py-2.5 text-right text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($merchants as $merchant)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-2.5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 flex-shrink-0">
                                        <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($merchant->name) }}&background=random" alt="">
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-xs font-bold text-gray-900 dark:text-gray-100">{{ $merchant->name }}</div>
                                        <div class="text-[10px] text-gray-500 dark:text-gray-400">{{ $merchant->user->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap">
                                <span class="px-2 py-0.5 inline-flex text-[10px] leading-4 font-bold rounded-full {{ $merchant->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 border-green-200' : 'bg-red-100 text-red-800 border-red-200' }} border dark:border-opacity-20">
                                    {{ ucfirst($merchant->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap">
                                <span class="text-xs text-gray-900 dark:text-gray-200 font-bold">Rp {{ number_format($merchant->volume, 0, ',', '.') }}</span>
                                <span class="block text-[10px] {{ $merchant->growth >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $merchant->growth >= 0 ? '▲' : '▼' }} {{ number_format(abs($merchant->growth), 1) }}% vs last month
                                </span>
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                {{ $merchant->last_active ? \Carbon\Carbon::parse($merchant->last_active)->diffForHumans() : 'Never' }}
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap text-right text-xs font-medium">
                                <div class="flex justify-end space-x-2 text-indigo-600 dark:text-indigo-400">
                                    <a href="#" class="hover:text-indigo-900 dark:hover:text-indigo-200 font-medium">Edit</a>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <a href="#" class="text-gray-400 hover:text-red-600 dark:hover:text-red-400">Disable</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-sm text-gray-500 text-center">No merchants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-white dark:bg-gray-800 px-4 py-2 border-t border-gray-200 dark:border-gray-700 sm:px-4">
             {{ $merchants->links() }}
        </div>
    </div>
        <!-- Modal -->
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- Modal Content -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900/50 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                    Add New Merchant
                                </h3>
                                <div class="mt-4 space-y-4">
                                     <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Merchant Name</label>
                                        <input type="text" placeholder="e.g. Toko Sukses Jaya" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                                        <input type="email" placeholder="email@example.com" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                                    </div>
                                     <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Business Type</label>
                                        <select class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                                            <option>Individual</option>
                                            <option>Corporate (PT/CV)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm" @click="openModal = false">
                            Create Merchant
                        </button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-500 shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="openModal = false">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
