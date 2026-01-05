@extends('layouts.app')

@section('content')
    <div class="bg-white shadow-xl sm:rounded-lg p-6">
        <div class="flex justify-between items-start mb-6">
            <h1 class="text-2xl font-bold">Transaction Request</h1>
            <a href="{{ route('admin.transactions.index') }}" class="text-gray-600 hover:text-gray-900">Back</a>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="col-span-2 space-y-6">
                <div class="bg-gray-50 p-6 rounded">
                    <h3 class="font-bold text-gray-900 mb-4">Data Transaksi</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-500 text-sm">Invoice ID</p>
                            <p class="font-bold">{{ $transaction->invoice_id }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Amount</p>
                            <p class="font-bold">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                        </div>
                         <div>
                            <p class="text-gray-500 text-sm">Merchant</p>
                            <p class="font-bold">{{ $transaction->merchant->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Status</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $transaction->status === 'SUCCESS' ? 'bg-green-100 text-green-800' : 
                                   ($transaction->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $transaction->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="border p-6 rounded">
                    <h3 class="font-bold text-gray-900 mb-2">Callback Logs</h3>
                    <p class="text-sm text-gray-500 mb-4">History pengiriman notifikasi ke merchant.</p>
                    
                    <ul class="space-y-3">
                        @forelse($transaction->website_callback_logs as $log)
                            <li class="p-3 bg-gray-50 rounded text-sm">
                                <div class="flex justify-between">
                                    <span class="font-bold">HTTP {{ $log->response_status }}</span>
                                    <span class="text-gray-500">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                                <code class="block mt-1 text-xs text-gray-600 truncate">{{ $log->payload }}</code>
                            </li>
                        @empty
                            <p class="text-gray-400 italic">Belum ada callback terkirim.</p>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="col-span-1">
                <div class="bg-indigo-50 p-6 rounded border border-indigo-100">
                    <h3 class="font-bold text-indigo-900 mb-4">Simulasi Pembayaran</h3>
                    <p class="text-sm text-indigo-700 mb-4">
                        Sebagai Admin/Switching, Anda dapat mensimulasikan pembayaran User secara manual.
                    </p>

                    @if($transaction->status === 'PENDING')
                        <form action="{{ route('admin.transactions.update_status', $transaction) }}" method="POST" class="space-y-3">
                            @csrf
                            <button type="submit" name="status" value="SUCCESS" class="w-full bg-green-600 text-white py-2 rounded font-bold hover:bg-green-700">
                                SIMULATE SUCCESS
                            </button>
                            <button type="submit" name="status" value="FAILED" class="w-full bg-red-600 text-white py-2 rounded font-bold hover:bg-red-700">
                                SIMULATE FAILED
                            </button>
                        </form>
                    @else
                        <div class="bg-gray-100 p-2 text-center rounded text-gray-500 font-bold">
                            TIDAK BISA DIUBAH
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
