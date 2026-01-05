<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function index()
    {
        $merchants = Merchant::with('user')->latest()->paginate(10);
        return view('admin.merchants.index', compact('merchants'));
    }

    public function show(Merchant $merchant)
    {
        $merchant->load('user', 'transactions');
        return view('admin.merchants.show', compact('merchant'));
    }

    public function update(Request $request, Merchant $merchant)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,banned',
        ]);

        $merchant->update(['status' => $request->status]);

        return back()->with('success', 'Merchant status updated successfully.');
    }
}
