<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function index()
    {
        $merchants = \App\Models\Merchant::with('user')->paginate(10);
        return view('admin.merchants.index', compact('merchants'));
    }

    public function show(\App\Models\Merchant $merchant)
    {
        $merchant->load('transactions');
        return view('admin.merchants.show', compact('merchant'));
    }
}
