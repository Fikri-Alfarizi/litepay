@extends('layouts.merchant')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Invoice</h2>

            <form action="{{ route('merchant.invoices.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="amount" class="block text-gray-700 font-bold mb-2">Amount (IDR)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="amount" id="amount"
                            class="pl-12 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="0.00" min="1000" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="customer_email" class="block text-gray-700 font-bold mb-2">Customer Email (Optional)</label>
                    <input type="email" name="customer_email" id="customer_email"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="customer@example.com">
                    <p class="text-xs text-gray-500 mt-1">We will send the invoice link to this email.</p>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-gray-700 font-bold mb-2">Description (Optional)</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('merchant.invoices.index') }}"
                        class="mr-3 px-4 py-2 text-gray-700 hover:text-gray-900">Cancel</a>
                    <button type="submit"
                        class="bg-blue-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-300">Create
                        Invoice</button>
                </div>
            </form>
        </div>
    </div>
@endsection