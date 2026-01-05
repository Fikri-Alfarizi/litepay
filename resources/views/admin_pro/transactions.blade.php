@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">Transactions</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Real-time monitoring of all payment flows.</p>
        </div>
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg shadow-sm transition flex items-center space-x-2 text-xs font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            <span>Export Report</span>
        </button>
    </div>

    <!-- Stats for Transactions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="bg-indigo-600 rounded-lg p-4 text-white shadow-md">
            <h3 class="text-indigo-200 text-xs font-semibold uppercase">Pending</h3>
            <p class="text-2xl font-bold mt-1">1,024</p>
            <div class="w-full bg-indigo-800 h-1 mt-3 rounded-full overflow-hidden">
                <div class="bg-indigo-300 h-1 w-3/4"></div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-gray-500 dark:text-gray-400 text-xs font-semibold uppercase">Success Rate</h3>
            <p class="text-2xl font-bold mt-1 text-green-600 dark:text-green-400">98.5%</p>
             <p class="text-[10px] text-gray-400 mt-0.5">Slightly higher than industry avg.</p>
        </div>
         <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-gray-500 dark:text-gray-400 text-xs font-semibold uppercase">Failed (Today)</h3>
            <p class="text-2xl font-bold mt-1 text-red-600 dark:text-red-400">12</p>
             <p class="text-[10px] text-gray-400 mt-0.5">Mostly user cancellations.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        <!-- Advanced Filter Toolbar -->
         <div class="p-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex flex-wrap gap-3 items-center">
             <select class="border border-gray-300 dark:border-gray-600 rounded-md text-xs px-2.5 py-1.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:border-indigo-500">
                 <option>All Statuses</option>
                 <option>Success</option>
                 <option>Pending</option>
                 <option>Failed</option>
             </select>
             
              <select class="border border-gray-300 dark:border-gray-600 rounded-md text-xs px-2.5 py-1.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:border-indigo-500">
                 <option>All Methods</option>
                 <option>Virtual Account</option>
                 <option>Credit Card</option>
                 <option>Qris</option>
             </select>

             <div class="flex-1 text-right">
                  <div class="relative inline-block w-56">
                    <input type="text" placeholder="Search by Ref ID..." class="pl-8 pr-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:ring-indigo-500 focus:border-indigo-500 w-full dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                    <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                 </div>
             </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ref ID</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Merchant</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @for ($i = 0; $i < 10; $i++)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-2.5 whitespace-nowrap">
                                <span class="font-mono text-[10px] text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded px-1.5 py-0.5">TRX-{{ rand(100000, 999999) }}</span>
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                {{ now()->subMinutes(rand(10, 500))->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap text-xs font-medium text-gray-900 dark:text-gray-100">
                                Merchant Partner #{{ rand(1, 5) }}
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap">
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-100">Rp {{ number_format(rand(50000, 5000000), 0, ',', '.') }}</span>
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap">
                                @php $status = ['SUCCESS', 'PENDING', 'FAILED'][rand(0, 2)]; @endphp
                                <span class="px-2 py-0.5 inline-flex text-[10px] leading-4 font-bold rounded-full 
                                    {{ $status==='SUCCESS' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : ($status==='PENDING' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300') }}">
                                    {{ $status }}
                                </span>
                            </td>
                             <td class="px-4 py-2.5 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                <button class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200 font-medium">View</button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        
         <!-- Pagination -->
        <div class="bg-white dark:bg-gray-800 px-4 py-2 border-t border-gray-200 dark:border-gray-700 sm:px-4">
            <nav class="flex items-center justify-between">
                <div class="hidden sm:block">
                     <p class="text-xs text-gray-700 dark:text-gray-300">Showing 1-10 of 1000</p>
                </div>
                <div class="flex-1 flex justify-between sm:justify-end">
                    <a href="#" class="relative inline-flex items-center px-3 py-1 border border-gray-300 dark:border-gray-600 text-xs font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">Previous</a>
                    <a href="#" class="ml-3 relative inline-flex items-center px-3 py-1 border border-gray-300 dark:border-gray-600 text-xs font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">Next</a>
                </div>
            </nav>
        </div>
    </div>
@endsection
