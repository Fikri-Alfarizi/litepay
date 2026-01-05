@extends('layouts.admin_pro')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Activity Log</h1>
            <p class="text-gray-500 mt-1">Audit trail of system actions.</p>
        </div>
        <button class="bg-gray-800 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-900 text-sm">Download Log</button>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="flow-root">
            <ul role="list" class="-mb-8">
                @foreach(range(1, 8) as $i)
                <li>
                    <div class="relative pb-8">
                        @if(!$loop->last)
                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                        @endif
                        <div class="relative flex space-x-3 p-4">
                            <div>
                                <span class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center ring-8 ring-white">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                <div>
                                    <p class="text-sm text-gray-500">
                                        <span class="font-medium text-gray-900">Administrator</span> 
                                        {{ ['updated settlement settings', 'approved payout #882', 'generated new API key', 'invited user finance@litepay.com'][$i % 4] }}
                                    </p>
                                </div>
                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                    {{ now()->subHours($i * 2)->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
