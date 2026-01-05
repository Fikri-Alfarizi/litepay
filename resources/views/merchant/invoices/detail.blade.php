@extends('layouts.app')

@section('content')
    <div class="bg-white shadow-xl sm:rounded-lg p-6">
        <div class="flex justify-between items-start mb-6">
            <h1 class="text-2xl font-bold">Invoice Details</h1>
            <a href="{{ route('merchant.invoices.index') }}" class="text-gray-600 hover:text-gray-900">Back to List</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded">
                <h3 class="font-bold text-gray-700 mb-2">Transaction Info</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Invoice ID:</span> {{ $invoice->invoice_id }}</p>
                    <p><span class="font-medium">Reference ID:</span> {{ $invoice->reference_id }}</p>
                    <p><span class="font-medium">Amount:</span> Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
                    <p><span class="font-medium">Status:</span> 
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $invoice->status === 'SUCCESS' ? 'bg-green-100 text-green-800' : 
                               ($invoice->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $invoice->status }}
                        </span>
                    </p>
                    <p><span class="font-medium">Created At:</span> {{ $invoice->created_at }}</p>
                </div>
            </div>

            <div class="bg-blue-50 p-4 rounded border border-blue-200">
                <h3 class="font-bold text-blue-800 mb-2">Simulation Payment Link</h3>
                <p class="text-sm text-blue-600 mb-3">Copy this link to pay, or use the Admin panel to simulate status change.</p>
                
                {{-- In real app, this would be the payment page. Here we just show the Ref ID to check status --}}
                <div class="bg-white p-2 rounded border font-mono text-sm break-all">
                    {{ url('/payment/pay/' . $invoice->reference_id) }} (Simulation URL)
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="font-bold text-lg mb-4">Callback Logs</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Attempt</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Response Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Response Body</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($invoice->website_callback_logs as $log)
                            <tr>
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $log->response_status }}</td>
                                <td class="px-4 py-2 text-xs font-mono truncate max-w-xs">{{ $log->response_body }}</td>
                                <td class="px-4 py-2">{{ $log->updated_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-center text-gray-500 text-sm">No callbacks sent yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
