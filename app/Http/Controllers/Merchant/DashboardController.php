<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Merchant;

class DashboardController extends Controller
{
    public function index()
    {
        // Assuming Auth::user() is linked to a merchant
        // For simulation, if we don't have full auth, we might just pick the first one or need RoleMiddleware to ensure user has merchant
        $user = Auth::user(); // Need to import Auth
        $merchant = $user->merchant;

        return view('merchant.dashboard', compact('merchant'));
    }
}
