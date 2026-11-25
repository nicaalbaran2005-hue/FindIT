<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AppNotification::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function markRead(AppNotification $notification)
    {
        $notification->update(['is_read' => true]);
        return back();
    }

    public function markAllRead()
    {
        AppNotification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'All notifications marked as read.');
    }
}