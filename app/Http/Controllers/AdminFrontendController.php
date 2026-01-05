<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminFrontendController extends Controller
{
    public function dashboard()
    {
        return view('admin_pro.dashboard');
    }

    public function merchants()
    {
        return view('admin_pro.merchants');
    }

    public function transactions()
    {
        return view('admin_pro.transactions');
    }

    public function settings()
    {
        return view('admin_pro.settings');
    }

    public function apiManagement()
    {
        return view('admin_pro.api_management');
    }

    public function callbacks()
    {
        return view('admin_pro.callbacks');
    }

    public function settlements()
    {
        return view('admin_pro.settlements');
    }

    public function risk()
    {
        return view('admin_pro.risk');
    }

    public function balance()
    {
        return view('admin_pro.balance');
    }

    public function promo()
    {
        return view('admin_pro.promo');
    }

    public function profile()
    {
        return view('admin_pro.account.profile');
    }

    public function ipWhitelist()
    {
        return view('admin_pro.account.ip_whitelist');
    }

    public function users()
    {
        return view('admin_pro.account.users');
    }

    public function activityLog()
    {
        return view('admin_pro.account.activity');
    }
}
