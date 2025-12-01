<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        return view('buyer.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->where('notification_id', $id)
            ->firstOrFail();

        $notification->update(['status' => 'Read']);

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('status', 'Unread')
            ->update(['status' => 'Read']);

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function deleteNotification($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->where('notification_id', $id)
            ->firstOrFail();

        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted.');
    }

    public function clearAll()
    {
        Notification::where('user_id', auth()->id())->delete();

        return redirect()->back()->with('success', 'All notifications cleared.');
    }
}
