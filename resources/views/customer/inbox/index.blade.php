@extends('layouts.mobile')

@section('content')
    <!-- Top Bar -->
    <div class="bg-white shadow-sm p-4 flex items-center sticky top-0 z-10">
        <a href="{{ route('store.index') }}" class="mr-4 text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="font-bold text-lg text-gray-800">Inbox</h1>
    </div>

    <div class="p-4 pb-24">
        @if($messages->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-gray-400">
                <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p>Belum ada pesan masuk.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($messages as $msg)
                    <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 {{ $msg->type === 'success' ? 'border-green-500' : 'border-blue-500' }}">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="font-bold text-gray-800">{{ $msg->title }}</h3>
                            <span class="text-[10px] text-gray-400">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">{{ $msg->message }}</p>
                        @if(!$msg->is_read)
                            <span class="inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
