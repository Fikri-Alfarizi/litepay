@extends('layouts.admin_pro')

@section('content')
    <div x-data="{ activeTab: 'general' }">
        <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-1">Settings</h1>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-6">Manage your account preferences and system configurations.</p>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Settings Sidebar -->
            <div class="lg:w-64 flex-shrink-0">
                <nav class="space-y-1">
                    <button @click="activeTab = 'general'" :class="{ 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 font-semibold': activeTab === 'general', 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800': activeTab !== 'general' }" class="w-full flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3 text-gray-400" :class="{ 'text-indigo-500': activeTab === 'general' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        General
                    </button>
                    <button @click="activeTab = 'profile'" :class="{ 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 font-semibold': activeTab === 'profile', 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800': activeTab !== 'profile' }" class="w-full flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3 text-gray-400" :class="{ 'text-indigo-500': activeTab === 'profile' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profile
                    </button>
                    <button @click="activeTab = 'security'" :class="{ 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 font-semibold': activeTab === 'security', 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800': activeTab !== 'security' }" class="w-full flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3 text-gray-400" :class="{ 'text-indigo-500': activeTab === 'security' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Security
                    </button>
                    <button @click="activeTab = 'notifications'" :class="{ 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 font-semibold': activeTab === 'notifications', 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800': activeTab !== 'notifications' }" class="w-full flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3 text-gray-400" :class="{ 'text-indigo-500': activeTab === 'notifications' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        Notifications
                    </button>
                    <button @click="activeTab = 'team'" :class="{ 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 font-semibold': activeTab === 'team', 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800': activeTab !== 'team' }" class="w-full flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3 text-gray-400" :class="{ 'text-indigo-500': activeTab === 'team' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Team Members
                    </button>
                    <button @click="activeTab = 'billing'" :class="{ 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 font-semibold': activeTab === 'billing', 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800': activeTab !== 'billing' }" class="w-full flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3 text-gray-400" :class="{ 'text-indigo-500': activeTab === 'billing' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Billing & Plans
                    </button>
                </nav>
            </div>

            <!-- Content Area -->
            <div class="flex-1 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-lg shadow-sm">
                
                <!-- General Tab -->
                <div x-show="activeTab === 'general'" class="p-6 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">General Settings</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Configure general system preferences.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Application Name</label>
                            <input type="text" value="LitePay Pro" class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Support Email</label>
                            <input type="email" value="support@litepay.com" class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Timezone</label>
                            <select class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option>UTC</option>
                                <option selected>Asia/Jakarta (GMT+7)</option>
                                <option>America/New_York (GMT-5)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Primary Currency</label>
                            <select class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option selected>IDR (Rupiah)</option>
                                <option>USD (Dollar)</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end pt-4">
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Save Changes</button>
                    </div>
                </div>

                <!-- Profile Tab -->
                <div x-show="activeTab === 'profile'" class="p-6 space-y-6" style="display: none;">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Profile Information</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Update your account's profile information and email address.</p>
                    </div>
                    <div class="flex items-center space-x-6">
                        <img src="https://ui-avatars.com/api/?name=Admin+System&background=6366f1&color=fff&size=128" class="w-20 h-20 rounded-full border-4 border-gray-100 dark:border-gray-700">
                        <div>
                            <button class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 px-3 py-1.5 rounded-md text-xs font-medium shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition">Change Avatar</button>
                            <p class="text-[10px] text-gray-500 mt-2">JPG, GIF or PNG. 1MB Max.</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                         <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                            <input type="text" value="Administrator System" class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                                <input type="email" value="superadmin@litepay.com" class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                             <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Phone Number</label>
                                <input type="text" value="+62 812 3456 7890" class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div>
                             <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Bio</label>
                             <textarea rows="3" class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">Super administrator managing global payments and system configurations.</textarea>
                        </div>
                    </div>
                     <div class="flex justify-end pt-4">
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Save Profile</button>
                    </div>
                </div>

                <!-- Security Tab -->
                <div x-show="activeTab === 'security'" class="p-6 space-y-6" style="display: none;">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Security Settings</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Ensure your account is using a long, random password to stay secure.</p>
                    </div>
                     <div class="space-y-4 max-w-lg">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Current Password</label>
                            <input type="password" class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">New Password</label>
                            <input type="password" class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                            <input type="password" class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Two-Factor Authentication</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Add additional security to your account using two-factor authentication.</p>
                            </div>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Enable 2FA</button>
                        </div>
                    </div>
                    <div class="flex justify-end pt-4">
                        <button class="bg-gray-800 hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Update Password</button>
                    </div>
                </div>

                <!-- Notifications Tab -->
                <div x-show="activeTab === 'notifications'" class="p-6 space-y-6" style="display: none;">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Notification Preferences</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Decide which communications you'd like to receive and how.</p>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="comments" name="comments" type="checkbox" checked class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="comments" class="font-medium text-gray-700 dark:text-gray-300">New Transaction Alerts</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Get notified when a new transaction is processed.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="candidates" name="candidates" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="candidates" class="font-medium text-gray-700 dark:text-gray-300">Failed Webhook Alerts</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Get notified when a callback fails after max retries.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                             <div class="flex items-center h-5">
                                <input id="offers" name="offers" type="checkbox" checked class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="offers" class="font-medium text-gray-700 dark:text-gray-300">Daily Digest</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Receive a daily summary of transaction volume and revenue.</p>
                            </div>
                        </div>
                    </div>
                     <div class="flex justify-end pt-4">
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Save Preferences</button>
                    </div>
                </div>

                <!-- Team Tab -->
                <div x-show="activeTab === 'team'" class="p-6 space-y-6" style="display: none;">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Team Members</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Manage who has access to this project.</p>
                    </div>
                    <div class="space-y-4">
                        @for($i=0; $i<3; $i++)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <img src="https://ui-avatars.com/api/?name={{ ['John Doe', 'Jane Smith', 'Mike Johnson'][$i] }}&background=random" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="text-sm font-bold text-gray-700 dark:text-gray-200">{{ ['John Doe', 'Jane Smith', 'Mike Johnson'][$i] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ ['john@example.com', 'jane@example.com', 'mike@example.com'][$i] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="bg-green-100 text-green-800 text-[10px] px-2 py-0.5 rounded-full font-bold dark:bg-green-900/50 dark:text-green-300">{{ ['Admin', 'Editor', 'Viewer'][$i] }}</span>
                                <button class="text-gray-400 hover:text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                </button>
                            </div>
                        </div>
                        @endfor
                    </div>
                    <button class="w-full py-2 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-gray-500 dark:text-gray-400 text-sm font-medium hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-500 dark:hover:border-indigo-400 transition">
                        + Add Team Member
                    </button>
                </div>
                 <!-- Billing Tab -->
                <div x-show="activeTab === 'billing'" class="p-6 space-y-6" style="display: none;">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Plan & Billing</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Manage your subscription and billing details.</p>
                    </div>
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-sm font-bold text-indigo-900 dark:text-indigo-200">Pro Plan</h4>
                                <p class="text-xs text-indigo-700 dark:text-indigo-400 mt-1">You are currently on the Pro plan.</p>
                            </div>
                            <span class="bg-indigo-100 text-indigo-800 text-[10px] font-bold px-2 py-1 rounded dark:bg-indigo-800 dark:text-indigo-200">Active</span>
                        </div>
                        <div class="mt-4">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">$29<span class="text-sm font-medium text-gray-500">/mo</span></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Next billing date: Feb 15, 2026</p>
                        </div>
                    </div>
                     <div class="flex justify-end pt-4">
                        <button class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium">Cancel Subscription</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
