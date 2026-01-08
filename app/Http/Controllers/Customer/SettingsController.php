<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('customer.settings.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function toggleNotification(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'required|boolean',
        ]);

        $user = Auth::user();
        $settings = $user->settings ?? [];
        $settings['notifications'][$request->key] = $request->value;

        $user->settings = $settings;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function updateBiometric(Request $request)
    {
        $request->validate([
            'enabled' => 'required|boolean',
            'token' => 'nullable|string'
        ]);

        $user = Auth::user();

        if ($request->enabled) {
            // Enable: Save token
            $user->biometric_token = $request->token ?? 'bio_' . uniqid();
            $settings = $user->settings ?? [];
            $settings['biometric_enabled'] = true;
            $user->settings = $settings;
        } else {
            // Disable: Clear token
            $user->biometric_token = null;
            $settings = $user->settings ?? [];
            $settings['biometric_enabled'] = false;
            $user->settings = $settings;
        }

        $user->save();

        return response()->json(['success' => true, 'token' => $user->biometric_token]);
    }
}
