@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-xl sm:rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Create New Invoice</h1>

        <form action="{{ route('merchant.invoices.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Amount (IDR)</label>
                <input type="number" name="amount" min="1000" class="w-full border p-2 rounded" placeholder="e.g 50000" required>
                <p class="text-sm text-gray-500 mt-1">Minimum Rp 1.000</p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('merchant.invoices.index') }}" class="mr-4 text-gray-600 hover:text-gray-900 py-2">Cancel</a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Generate Invoice</button>
            </div>
        </form>
    </div>
@endsection
