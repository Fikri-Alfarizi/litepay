@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">API Management</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Manage API keys and integration settings.</p>
        </div>
        <button onclick="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow transition flex items-center space-x-2 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            <span>Generate New Key</span>
        </button>
    </div>

    <!-- Usage Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
            <h3 class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase">Requests Today</h3>
            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-2">45,231</p>
            <p class="text-xs text-green-500 mt-1">Within limits</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
            <h3 class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase">Average Latency</h3>
            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-2">124ms</p>
            <p class="text-xs text-yellow-500 mt-1">Slightly elevated</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
            <h3 class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase">System Status</h3>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-2">Operational</p>
            <p class="text-xs text-gray-400 mt-1">All systems go</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <h3 class="font-bold text-gray-700 dark:text-gray-200">Active API Keys</h3>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            <div class="p-6 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <div>
                    <div class="flex items-center space-x-3 mb-1">
                        <span class="font-bold text-gray-800 dark:text-gray-100">Key Name: Live Secret Key</span>
                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Active</span>
                    </div>
                    <div class="flex items-center gap-2">
                         <code class="text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded" id="apiKeyDisplay">{{ $merchant->api_key }}</code>
                         <button onclick="navigator.clipboard.writeText('{{ $merchant->api_key }}')" class="text-xs text-indigo-500 hover:underline">Copy</button>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Use this key in the <code>X-API-KEY</code> header for all API requests.</p>
                </div>
                <div class="flex space-x-3">
                    <button onclick="openModal()" class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 text-sm font-medium">Regenerate</button>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-indigo-600 dark:bg-indigo-900 rounded-xl shadow p-8 text-white flex justify-between items-center transition-colors duration-200">
        <div>
            <h3 class="text-xl font-bold">API Documentation</h3>
            <p class="text-indigo-100 dark:text-indigo-200 mt-1">Learn how to integrate specific endpoints and handle webhooks.</p>
        </div>
        <button class="bg-white text-indigo-600 dark:text-indigo-900 px-6 py-3 rounded-lg font-bold hover:bg-indigo-50 transition">View Docs</button>
    </div>

    <!-- Generate Key Modal -->
    <div id="generateKeyModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 w-full max-w-md transform transition-all scale-100">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">Regenerate API Key?</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                This action will <span class="text-red-500 font-bold">invalidate the current API Key immediately</span>. Any applications using the old key will stop working until updated.
            </p>
            
            <form action="{{ route('admin_pro.api.regenerate') }}" method="POST">
                @csrf
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium text-sm">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm shadow-lg shadow-red-500/30">Yes, Regenerate Key</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('generateKeyModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('generateKeyModal').classList.add('hidden');
        }
    </script>
@endsection
