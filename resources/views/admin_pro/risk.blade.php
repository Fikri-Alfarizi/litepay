@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Risk Management</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Fraud Guard AI & Blocklists.</p>
        </div>
        <div class="flex space-x-3">
             <button class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg shadow transition flex items-center space-x-2 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>Add to Blacklist</span>
            </button>
        </div>
    </div>

    <!-- Fraud Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="col-span-3 bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
             <div class="flexjustify-between items-center mb-4">
                <h3 class="font-bold text-gray-700 dark:text-gray-200">Fraud Attempts Detected (Real-time)</h3>
            </div>
            <!-- Mock Chart Area -->
             <div class="h-40 flex items-end space-x-2">
                @for($i=0; $i<30; $i++)
                    <div class="w-full bg-red-100 dark:bg-red-900/30 rounded-t hover:bg-red-200 dark:hover:bg-red-900/50 relative group">
                        @php $h = rand(10, 80); @endphp
                        <div class="absolute bottom-0 w-full bg-red-400 dark:bg-red-600 rounded-t" style="height: {{ $h }}%"></div>
                    </div>
                @endfor
            </div>
             <div class="text-center text-xs text-gray-400 mt-2">Last 30 Minutes</div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
             <h3 class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase mb-4">Risk Score Distribution</h3>
             <div class="space-y-4">
                 <div>
                     <div class="flex justify-between text-xs mb-1">
                         <span class="text-green-600 dark:text-green-400 font-bold">Low</span>
                         <span class="text-gray-600 dark:text-gray-300">85%</span>
                     </div>
                     <div class="w-full bg-gray-100 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                         <div class="bg-green-500 h-2 w-10/12"></div>
                     </div>
                 </div>
                 <div>
                     <div class="flex justify-between text-xs mb-1">
                         <span class="text-yellow-600 dark:text-yellow-400 font-bold">Medium</span>
                         <span class="text-gray-600 dark:text-gray-300">12%</span>
                     </div>
                     <div class="w-full bg-gray-100 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                         <div class="bg-yellow-500 h-2 w-2/12"></div>
                     </div>
                 </div>
                 <div>
                     <div class="flex justify-between text-xs mb-1">
                         <span class="text-red-600 dark:text-red-400 font-bold">High</span>
                         <span class="text-gray-600 dark:text-gray-300">3%</span>
                     </div>
                     <div class="w-full bg-gray-100 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                         <div class="bg-red-500 h-2 w-1/12"></div>
                     </div>
                 </div>
             </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
            <h3 class="font-bold text-gray-700 dark:text-gray-200">Flagged Transactions</h3>
            <span class="bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 py-1 px-3 rounded-full text-xs font-bold animate-pulse">Live Monitoring</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Risk Score</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reason</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">IP Address</th>
                         <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @for ($i = 0; $i < 6; $i++)
                        @php $score = rand(70, 99); @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-lg font-bold {{ $score > 85 ? 'text-red-600 dark:text-red-400' : 'text-yellow-600 dark:text-yellow-400' }}">{{ $score }}</span>
                                <span class="text-xs text-gray-400">/100</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="block text-sm font-bold text-gray-800 dark:text-gray-100">
                                    {{ ['Velocity Limit Exceeded', 'Suspicious IP Location', 'Card Bin Blacklisted'][$i % 3] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="block text-sm text-gray-600 dark:text-gray-300 font-mono">TRX-{{ rand(1000, 9999) }}</span>
                                <span class="text-xs text-gray-400">Rp {{ number_format(rand(1000000, 5000000), 0, ',', '.') }}</span>
                            </td>
                             <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono text-gray-600 dark:text-gray-400">{{ rand(1, 255) }}.{{ rand(1, 255) }}.{{ rand(1, 255) }}.{{ rand(1, 255) }}</span>
                                <span class="block text-xs text-gray-400">{{ ['US', 'RU', 'CN', 'NG'][$i % 4] }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200 border border-red-200 dark:border-red-800 px-3 py-1 rounded bg-red-50 dark:bg-red-900/20">Block</button>
                                <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 ml-2">Ignore</button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
