<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function index()
    {
        $messages = Inbox::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Mark as read
        Inbox::where('user_id', Auth::id())->update(['is_read' => true]);

        return view('customer.inbox.index', compact('messages'));
    }

    public function getUnreadCount()
    {
        $count = Inbox::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $count]);
    }
}
