@extends('layouts.admin_pro')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Account Profile</h1>

        <div class="bg-white rounded-xl shadow overflow-hidden pb-6">
             <div class="h-32 bg-indigo-600"></div>
             <div class="px-8 flex justify-between items-end -mt-12">
                 <div class="flex items-end">
                     <img src="https://ui-avatars.com/api/?name=Admin+System&background=random&size=128" class="w-24 h-24 rounded-full border-4 border-white shadow-lg">
                     <div class="ml-4 mb-2">
                         <h2 class="text-xl font-bold text-gray-800">Administrator</h2>
                         <p class="text-gray-500 text-sm">superadmin@litepay.com</p>
                     </div>
                 </div>
                 <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-indigo-700 mb-2">Save Changes</button>
             </div>
             
             <div class="px-8 mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                 <div>
                     <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                     <input type="text" value="Administrator" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                     <input type="email" value="superadmin@litepay.com" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                 </div>
                  <div>
                     <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                     <input type="text" value="Super Admin" disabled class="w-full border border-gray-300 bg-gray-100 rounded-lg px-3 py-2 text-gray-500 cursor-not-allowed">
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                     <input type="text" value="+62 812 3456 7890" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                 </div>
             </div>

             <div class="px-8 mt-8">
                 <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Security</h3>
                 <div class="flex items-center justify-between py-4">
                     <div>
                         <p class="font-medium text-gray-900">Change Password</p>
                         <p class="text-sm text-gray-500">Update your account password periodically.</p>
                     </div>
                     <button class="text-indigo-600 font-medium hover:text-indigo-800">Update</button>
                 </div>
                  <div class="flex items-center justify-between py-4 border-t border-gray-100">
                     <div>
                         <p class="font-medium text-gray-900">Two-Factor Authentication</p>
                         <p class="text-sm text-gray-500">Add an extra layer of security to your account.</p>
                     </div>
                     <button class="bg-green-100 text-green-700 px-3 py-1 rounded text-sm font-bold">Enabled</button>
                 </div>
             </div>
        </div>
    </div>
@endsection
