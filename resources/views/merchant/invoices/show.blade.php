@extends('layouts.merchant')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Invoice Details</h3>
                <span
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    {{ $transaction->status === 'paid' ? 'bg-green-100 text-green-800' :
        ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($transaction->status) }}
                </span>
            </div>
            <div class="px-6 py-5">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div class="col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Reference ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $transaction->reference_id }}</dd>
                    </div>
                    <div class="col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Amount</dt>
                        <dd class="mt-1 text-xl font-bold text-gray-900">IDR
                            {{ number_format($transaction->amount, 0, ',', '.') }}</dd>
                    </div>
                    <div class="col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $transaction->created_at->format('d M Y H:i:s') }}</dd>
                    </div>
                    @if($transaction->paid_at)
                        <div class="col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Paid At</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($transaction->paid_at)->format('d M Y H:i:s') }}</dd>
                        </div>
                    @endif
                </dl>

                <div class="mt-8 border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Payment Link</h4>
                    <div class="flex items-center gap-2">
                        <input type="text" readonly value="{{ route('checkout.show', $transaction->reference_id) }}"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                        <a href="{{ route('checkout.show', $transaction->reference_id) }}" target="_blank"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                            Open
                        </a>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Share this link with your customer to collect payment.</p>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <a href="{{ route('merchant.invoices.index') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-500">Back to Invoices</a>
            </div>
        </div>
    </div>
@endsection