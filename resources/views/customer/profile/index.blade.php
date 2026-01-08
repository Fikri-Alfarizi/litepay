@extends('layouts.mobile')

@section('content')
    <!-- Top Bar -->
    <div class="bg-white shadow-sm p-4 sticky top-0 z-10 text-center">
        <h1 class="font-bold text-lg text-gray-800">My Profile</h1>
    </div>

    <div class="p-4">
        <!-- Profile info -->
        <div class="bg-white rounded-xl p-6 shadow-sm mb-6 text-center">
            <div
                class="w-20 h-20 bg-blue-100 rounded-full mx-auto flex items-center justify-center text-blue-600 mb-3 text-2xl font-bold">
                {{ substr($user->name, 0, 2) }}
            </div>
            <h2 class="font-bold text-xl text-gray-800">{{ $user->name }}</h2>
            <p class="text-gray-500">{{ $user->email }}</p>
        </div>

        <!-- Menu -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <a href="{{ route('customer.history') }}"
                class="flex items-center justify-between p-4 border-b border-gray-100 hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700">Transaction History</span>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>

            <a href="#"
                class="flex items-center justify-between p-4 border-b border-gray-100 hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-100 p-2 rounded-lg text-purple-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700">Settings</span>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <!-- Linked Accounts -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 p-4">
            <h3 class="font-bold text-gray-800 mb-4">Linked Accounts</h3>
            
            <div class="space-y-4 mb-4">
                @foreach($linkedAccounts as $account)
                <div class="flex items-center justify-between border p-3 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center font-bold text-xs">
                            {{ strtoupper($account->provider) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 capitalize">{{ $account->provider }}</p>
                            <p class="text-xs text-gray-500">{{ $account->account_number }}</p>
                        </div>
                    </div>
                    <form action="{{ route('customer.profile.unlink_account', $account->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 text-xs font-bold">Unlink</button>
                    </form>
                </div>
                @endforeach
            </div>

            <button onclick="document.getElementById('link-modal').classList.remove('hidden')" class="w-full border border-blue-600 text-blue-600 font-bold py-3 rounded-xl hover:bg-blue-50 transition">
                + Link New Account
            </button>
        </div>

        <!-- Security (PIN) -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 p-4">
            <h3 class="font-bold text-gray-800 mb-4">Security</h3>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-bold text-gray-800">Transaction PIN</p>
                    <p class="text-xs text-gray-500">{{ $user->pin ? 'PIN is set' : 'PIN not set' }}</p>
                </div>
                <button onclick="document.getElementById('pin-modal').classList.remove('hidden')" class="text-blue-600 font-bold text-sm">
                    {{ $user->pin ? 'Change' : 'Set PIN' }}
                </button>
            </div>
        </div>

        <form action="{{ route('customer.logout') }}" method="POST" class="mt-8">
            @csrf
            <button type="submit"
                class="w-full bg-red-50 text-red-600 font-bold py-4 rounded-xl hover:bg-red-100 transition shadow-sm border border-red-100">
                Logout
            </button>
        </form>
    </div>

    <!-- Link Account Modal -->
    <div id="link-modal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-end sm:items-center justify-center">
        <div class="bg-white w-full sm:w-96 rounded-t-2xl sm:rounded-2xl p-6 relative">
            <h3 class="font-bold text-lg mb-4">Link Account</h3>
            <form action="{{ route('customer.profile.link_account') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provider</label>
                    <select name="provider" class="w-full border rounded-lg p-3">
                        <option value="dana">DANA</option>
                        <option value="ovo">OVO</option>
                        <option value="gopay">GoPay</option>
                        <option value="shopeepay">ShopeePay</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="account_number" class="w-full border rounded-lg p-3" placeholder="0812..." required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl mb-2">Link Account</button>
                <button type="button" onclick="document.getElementById('link-modal').classList.add('hidden')" class="w-full text-gray-500 py-3">Cancel</button>
            </form>
        </div>
    </div>

    <!-- PIN Modal -->
    <div id="pin-modal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-end sm:items-center justify-center">
        <div class="bg-white w-full sm:w-96 rounded-t-2xl sm:rounded-2xl p-6 relative">
            <h3 class="font-bold text-lg mb-4">{{ $user->pin ? 'Change PIN' : 'Set PIN' }}</h3>
            <form action="{{ route('customer.profile.set_pin') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">New PIN (6 Digits)</label>
                    <input type="password" name="pin" maxlength="6" class="w-full border rounded-lg p-3 text-center text-2xl tracking-widest" placeholder="••••••" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm PIN</label>
                    <input type="password" name="pin_confirmation" maxlength="6" class="w-full border rounded-lg p-3 text-center text-2xl tracking-widest" placeholder="••••••" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl mb-2">Save PIN</button>
                <button type="button" onclick="document.getElementById('pin-modal').classList.add('hidden')" class="w-full text-gray-500 py-3">Cancel</button>
            </form>
        </div>
    </div>
@endsection