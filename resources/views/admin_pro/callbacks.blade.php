@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Callback Logs</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Monitor webhook delivery status.</p>
        </div>
        <div class="flex space-x-3">
             <button onclick="window.location.reload()" class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span>Refresh</span>
            </button>
            <a href="{{ route('admin_pro.api') }}" class="bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition flex items-center">Config Settings</a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction Ref</th>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">URL</th>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Attempts</th>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Time</th>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Payload</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($callbacks as $callback)
                        @php $status = $callback->response_status; @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-3 py-2 whitespace-nowrap">
                                <span class="px-1.5 py-0.5 inline-flex text-[10px] leading-4 font-semibold rounded-md {{ $status >= 200 && $status < 300 ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300' }}">
                                    POST {{ $status ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                <span class="font-mono text-[10px] text-gray-600 dark:text-gray-400">{{ $callback->transaction->reference_id }}</span>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-[10px] text-gray-500 dark:text-gray-400">
                                <div class="max-w-[150px] truncate" title="{{ $callback->transaction->merchant->callback_url ?? 'N/A' }}">
                                    {{ $callback->transaction->merchant->callback_url ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-[10px] text-gray-500 dark:text-gray-400">
                                {{ $callback->attempts }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-[10px] text-gray-500 dark:text-gray-400">
                                {{ $callback->created_at->diffForHumans() }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-[10px] text-gray-500 dark:text-gray-400">
                                <button class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-medium text-[10px] border border-indigo-200 dark:border-indigo-800 px-1.5 py-0.5 rounded bg-indigo-50 dark:bg-indigo-900/30">View Payload</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-sm text-gray-500">No callback logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
