<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $linkedAccounts = $user->linkedAccounts;
        return view('customer.profile.index', compact('user', 'linkedAccounts'));
    }

    public function linkAccount(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'account_number' => 'required|string',
        ]);

        Auth::user()->linkedAccounts()->create([
            'provider' => $request->provider,
            'account_number' => $request->account_number,
            'account_name' => 'John Doe', // Simulation
        ]);

        return back()->with('success', 'Account linked successfully!');
    }

    public function unlinkAccount($id)
    {
        Auth::user()->linkedAccounts()->findOrFail($id)->delete();
        return back()->with('success', 'Account unlinked successfully!');
    }

    public function setPin(Request $request)
    {
        $request->validate([
            'pin' => 'required|digits:6|confirmed',
        ]);

        Auth::user()->update([
            'pin' => bcrypt($request->pin),
        ]);

        return back()->with('success', 'PIN updated successfully!');
    }
}
