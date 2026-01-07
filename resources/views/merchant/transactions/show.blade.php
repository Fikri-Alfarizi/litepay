@extends('layouts.merchant')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Transaction Details</h3>
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
                        <dt class="text-sm font-medium text-gray-500">Invoice ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $transaction->invoice_id }}</dd>
                    </div>
                    <div class="col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Product</dt>
                        <dd class="mt-1 text-sm font-bold text-blue-600">{{ $orderPayment->order->product_name ?? 'Digital Product' }}</dd>
                    </div>
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
                        <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $transaction->payment_method ?? 'QRIS' }}
                        </dd>
                    </div>
                    <div class="col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Paid At</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $transaction->paid_at ? \Carbon\Carbon::parse($transaction->paid_at)->format('d M Y H:i:s') : '-' }}
                        </dd>
                    </div>
                </dl>
            </div>

            @if($transaction->callbackAttempts->count() > 0)
                <div class="px-6 py-5 border-t border-gray-200">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Callback History</h4>
                    <div class="bg-gray-50 rounded-lg p-4 font-mono text-xs overflow-x-auto">
                        <ul class="space-y-4">
                            @foreach($transaction->callbackAttempts as $attempt)
                                <li class="border-b pb-2 last:border-b-0 last:pb-0">
                                    <p class="text-gray-500 mb-1">{{ $attempt->created_at->format('Y-m-d H:i:s') }}</p>
                                    <p class="text-blue-600 font-bold uppercase">URL: {{ $attempt->callback_url }}</p>
                                    <p class="font-bold {{ $attempt->status === 'SUCCESS' ? 'text-green-600' : 'text-red-600' }}">
                                        RESPONSE: {{ $attempt->response_code }} ({{ $attempt->status }})
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <a href="{{ route('merchant.transactions.index') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-500">Back to Transactions</a>
            </div>
        </div>
    </div>
@endsection