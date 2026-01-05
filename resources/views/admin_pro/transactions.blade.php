@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Transactions</h1>
            <p class="text-gray-500 mt-1">Real-time monitoring of all payment flows.</p>
        </div>
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow transition flex items-center space-x-2 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            <span>Export Report</span>
        </button>
    </div>

    <!-- Stats for Transactions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-indigo-600 rounded-xl p-6 text-white shadow-lg">
            <h3 class="text-indigo-200 text-sm font-semibold uppercase">Pending</h3>
            <p class="text-3xl font-bold mt-2">1,024</p>
            <div class="w-full bg-indigo-800 h-1 mt-4 rounded-full overflow-hidden">
                <div class="bg-indigo-300 h-1 w-3/4"></div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <h3 class="text-gray-500 text-sm font-semibold uppercase">Success Rate</h3>
            <p class="text-3xl font-bold mt-2 text-green-600">98.5%</p>
             <p class="text-xs text-gray-400 mt-1">Slightly higher than industry avg.</p>
        </div>
         <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <h3 class="text-gray-500 text-sm font-semibold uppercase">Failed (Today)</h3>
            <p class="text-3xl font-bold mt-2 text-red-600">12</p>
             <p class="text-xs text-gray-400 mt-1">Mostly user cancellations.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <!-- Advanced Filter Toolbar -->
         <div class="p-5 border-b border-gray-100 bg-gray-50 flex flex-wrap gap-4 items-center">
             <select class="border border-gray-300 rounded-lg text-sm px-3 py-2 bg-white focus:outline-none focus:border-indigo-500">
                 <option>All Statuses</option>
                 <option>Success</option>
                 <option>Pending</option>
                 <option>Failed</option>
             </select>
             
              <select class="border border-gray-300 rounded-lg text-sm px-3 py-2 bg-white focus:outline-none focus:border-indigo-500">
                 <option>All Methods</option>
                 <option>Virtual Account</option>
                 <option>Credit Card</option>
                 <option>Qris</option>
             </select>

             <div class="flex-1 text-right">
                  <div class="relative inline-block w-64">
                    <input type="text" placeholder="Search by Ref ID..." class="pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 w-full">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                 </div>
             </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ref ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Merchant</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @for ($i = 0; $i < 10; $i++)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-xs text-gray-600 bg-gray-100 rounded px-2 py-1">TRX-{{ rand(100000, 999999) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ now()->subMinutes(rand(10, 500))->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Merchant Partner #{{ rand(1, 5) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-gray-800">Rp {{ number_format(rand(50000, 5000000), 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php $status = ['SUCCESS', 'PENDING', 'FAILED'][rand(0, 2)]; @endphp
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $status==='SUCCESS' ? 'bg-green-100 text-green-800' : ($status==='PENDING' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $status }}
                                </span>
                            </td>
                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-indigo-600 hover:text-indigo-900 font-medium">View</button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        
         <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            <nav class="flex items-center justify-between">
                <div class="hidden sm:block">
                     <p class="text-sm text-gray-700">Showing 1-10 of 1000</p>
                </div>
                <div class="flex-1 flex justify-between sm:justify-end">
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Previous</a>
                    <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Next</a>
                </div>
            </nav>
        </div>
    </div>
@endsection
