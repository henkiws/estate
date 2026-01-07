<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the authenticated user
     */
    public function index(Request $request)
    {
        $query = Notification::where('recipient_id', auth()->id())
            ->sent()
            ->latest();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Status filter (read/unread)
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->unread();
            } elseif ($request->status === 'read') {
                $query->read();
            }
        }

        // Priority filter
        if ($request->filled('priority')) {
            $query->priority($request->priority);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->category($request->category);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Paginate results
        $notifications = $query->paginate(20)->appends($request->except('page'));

        // Statistics
        $stats = [
            'total' => Notification::where('recipient_id', auth()->id())->sent()->count(),
            'unread' => Notification::where('recipient_id', auth()->id())->unread()->count(),
            'read' => Notification::where('recipient_id', auth()->id())->read()->count(),
            'today' => Notification::where('recipient_id', auth()->id())
                ->sent()
                ->whereDate('created_at', today())
                ->count(),
            'this_week' => Notification::where('recipient_id', auth()->id())
                ->sent()
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
        ];

        // Category counts
        $categoryCounts = Notification::where('recipient_id', auth()->id())
            ->sent()
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');

        return view('user.notifications.index', compact('notifications', 'stats', 'categoryCounts'));
    }

    /**
     * Display a single notification
     */
    public function show(Notification $notification)
    {
        // Check if notification belongs to authenticated user
        if ($notification->recipient_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this notification.');
        }

        // Mark as read if not already read
        if ($notification->isUnread()) {
            $notification->markAsRead();
        }

        // Get previous and next notifications for navigation
        $previous = Notification::where('recipient_id', auth()->id())
            ->sent()
            ->where('id', '<', $notification->id)
            ->orderBy('id', 'desc')
            ->first();

        $next = Notification::where('recipient_id', auth()->id())
            ->sent()
            ->where('id', '>', $notification->id)
            ->orderBy('id', 'asc')
            ->first();

        return view('user.notifications.show', compact('notification', 'previous', 'next'));
    }
}