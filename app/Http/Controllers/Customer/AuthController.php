<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('customer.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role !== 'customer') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'This account is not a customer account.',
                ]);
            }

            return redirect()->intended(route('store.index'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegister()
    {
        return view('customer.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:merchant.users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        Auth::login($user);

        return redirect(route('store.index'));
    }

    public function loginBiometric(Request $request)
    {
        $request->validate([
            'face_descriptor' => 'required|array',
        ]);

        // Get all customers with biometric enabled
        $users = User::where('role', 'customer')
            ->whereNotNull('face_descriptor')
            ->whereNotNull('biometric_token')
            ->get();

        $liveDescriptor = $request->face_descriptor;
        $bestMatch = null;
        $bestDistance = PHP_FLOAT_MAX;
        $threshold = 0.5; // Lower distance = better match

        foreach ($users as $user) {
            $storedDescriptor = json_decode($user->face_descriptor, true);

            if (!$storedDescriptor || count($storedDescriptor) !== count($liveDescriptor)) {
                continue;
            }

            // Calculate euclidean distance
            $distance = 0;
            for ($i = 0; $i < count($liveDescriptor); $i++) {
                $distance += pow($liveDescriptor[$i] - $storedDescriptor[$i], 2);
            }
            $distance = sqrt($distance);

            if ($distance < $bestDistance) {
                $bestDistance = $distance;
                $bestMatch = $user;
            }
        }

        // Check if best match is within threshold
        if ($bestMatch && $bestDistance < $threshold && ($bestMatch->settings['biometric_enabled'] ?? false)) {
            Auth::login($bestMatch);
            $request->session()->regenerate();

            // Return JSON for AJAX request
            return response()->json([
                'success' => true,
                'redirect' => route('store.index'),
                'user' => $bestMatch->name,
                'distance' => round($bestDistance, 3)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Face not recognized. Please use password.'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('customer.login');
    }
}
