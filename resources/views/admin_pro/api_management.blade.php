@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">API Management</h1>
            <p class="text-gray-500 mt-1">Manage API keys and integration settings.</p>
        </div>
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow transition flex items-center space-x-2 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            <span>Generate New Key</span>
        </button>
    </div>

    <!-- Usage Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-indigo-500">
            <h3 class="text-gray-500 text-xs font-bold uppercase">Requests Today</h3>
            <p class="text-2xl font-bold text-gray-800 mt-2">45,231</p>
            <p class="text-xs text-green-500 mt-1">Within limits</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-yellow-500">
            <h3 class="text-gray-500 text-xs font-bold uppercase">Average Latency</h3>
            <p class="text-2xl font-bold text-gray-800 mt-2">124ms</p>
            <p class="text-xs text-yellow-500 mt-1">Slightly elevated</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-green-500">
            <h3 class="text-gray-500 text-xs font-bold uppercase">System Status</h3>
            <p class="text-2xl font-bold text-green-600 mt-2">Operational</p>
            <p class="text-xs text-gray-400 mt-1">All systems go</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="font-bold text-gray-700">Active API Keys</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @for ($i = 1; $i <= 3; $i++)
            <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition">
                <div>
                    <div class="flex items-center space-x-3 mb-1">
                        <span class="font-bold text-gray-800">Key Name: {{ ['Production Key', 'Staging Key', 'Mobile App Key'][$i-1] }}</span>
                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800">Active</span>
                    </div>
                    <code class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">sk_live_{{ \Illuminate\Support\Str::random(24) }}</code>
                    <p class="text-xs text-gray-400 mt-2">Created {{ now()->subMonths($i)->format('d M Y') }} • Last used {{ rand(1, 59) }} mins ago</p>
                </div>
                <div class="flex space-x-3">
                    <button class="text-gray-400 hover:text-indigo-600">Regenerate</button>
                    <button class="text-gray-400 hover:text-red-600">Revoke</button>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <div class="bg-indigo-900 rounded-xl shadow p-8 text-white flex justify-between items-center">
        <div>
            <h3 class="text-xl font-bold">API Documentation</h3>
            <p class="text-indigo-200 mt-1">Learn how to integrate specific endpoints and handle webhooks.</p>
        </div>
        <button class="bg-white text-indigo-900 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition">View Docs</button>
    </div>
@endsection
