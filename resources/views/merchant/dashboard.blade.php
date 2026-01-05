@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Merchant Dashboard</h1>
        <p class="mb-4">Welcome back!</p>
        
        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded">
            <h3 class="font-bold text-yellow-800">Integration Details</h3>
            <p class="text-sm text-yellow-700 mt-2">API Key: <span class="font-mono bg-yellow-100 p-1 rounded">HIDDEN</span></p>
            <p class="text-sm text-yellow-700 mt-1">Callback URL: <span class="font-mono bg-yellow-100 p-1 rounded">Not Set</span></p>
        </div>
    </div>
@endsection
