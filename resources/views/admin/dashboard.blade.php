@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-100 p-4 rounded text-blue-800">
                <h3 class="font-bold">Total Transactions</h3>
                <p class="text-xl">0</p>
            </div>
            <div class="bg-green-100 p-4 rounded text-green-800">
                <h3 class="font-bold">Success</h3>
                <p class="text-xl">0</p>
            </div>
            <div class="bg-red-100 p-4 rounded text-red-800">
                <h3 class="font-bold">Failed</h3>
                <p class="text-xl">0</p>
            </div>
        </div>
    </div>
@endsection
