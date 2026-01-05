@extends('layouts.app')

@section('content')
    <div class="bg-white shadow-xl sm:rounded-lg p-6">
        <div class="flex justify-between items-start mb-6">
            <h1 class="text-2xl font-bold">{{ $merchant->name }}</h1>
            <a href="{{ route('admin.merchants.index') }}" class="text-gray-600 hover:text-gray-900">Back to List</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded">
                <h3 class="font-bold text-gray-700 mb-2">Merchant Profile</h3>
                <p><span class="font-medium">Owner:</span> {{ $merchant->user->name }}</p>
                <p><span class="font-medium">Email:</span> {{ $merchant->user->email }}</p>
                <p><span class="font-medium">Status:</span> {{ $merchant->status }}</p>
            </div>
            <div class="bg-yellow-50 p-4 rounded border border-yellow-200">
                <h3 class="font-bold text-yellow-800 mb-2">Integration Credentials</h3>
                <div class="mb-2">
                    <p class="text-xs text-yellow-600 uppercase">API Key</p>
                    <code class="block bg-white p-1 rounded border overflow-x-auto">{{ $merchant->api_key }}</code>
                </div>
                <div>
                    <p class="text-xs text-yellow-600 uppercase">API Secret</p>
                    <code class="block bg-white p-1 rounded border overflow-x-auto">{{ $merchant->api_secret }}</code>
                </div>
            </div>
        </div>

        <h3 class="font-bold text-lg mb-4">Recent Transactions</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Invoice ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Amount</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($merchant->transactions->take(10) as $transaction)
                        <tr>
                            <td class="px-4 py-2">{{ $transaction->invoice_id }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $transaction->status }}</td>
                            <td class="px-4 py-2">{{ $transaction->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">No recent transactions.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
