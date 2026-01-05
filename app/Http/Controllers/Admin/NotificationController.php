<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display notification dashboard
     */
    public function index(Request $request)
    {
        $query = Notification::with(['sender', 'recipient'])
            ->where('type', 'broadcast'); // Only show broadcast notifications in admin panel

        // Filters
        if ($request->filled('status')) {
            match($request->status) {
                'sent' => $query->sent(),
                'scheduled' => $query->scheduled(),
                'pending' => $query->pending(),
                default => null,
            };
        }

        if ($request->filled('priority')) {
            $query->priority($request->priority);
        }

        if ($request->filled('category')) {
            $query->category($request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $notifications = $query->latest()->paginate(20)->appends($request->except('page'));

        // Statistics
        $stats = [
            'total' => Notification::where('type', 'broadcast')->count(),
            'sent' => Notification::where('type', 'broadcast')->sent()->count(),
            'scheduled' => Notification::where('type', 'broadcast')->scheduled()->count(),
            'pending' => Notification::where('type', 'broadcast')->pending()->count(),
            'total_recipients' => Notification::where('type', 'broadcast')->sent()->count(),
            'read_count' => Notification::where('type', 'broadcast')->read()->count(),
            'unread_count' => Notification::where('type', 'broadcast')->unread()->count(),
        ];

        return view('admin.notifications.index', compact('notifications', 'stats'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $users = User::select('id', 'name', 'email', 'role')->orderBy('name')->get();
        
        return view('admin.notifications.create', compact('users'));
    }

    /**
     * Store new broadcast notification
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'category' => 'required|in:general,payment,approval,document,support,subscription,maintenance',
            'priority' => 'required|in:low,medium,high',
            'target_type' => 'required|in:all,all_users,all_agencies,all_agents,specific',
            'specific_users' => 'required_if:target_type,specific|array',
            'specific_users.*' => 'exists:users,id',
            'action_url' => 'nullable|url',
            'action_text' => 'nullable|string|max:50',
            'schedule' => 'nullable|boolean',
            'scheduled_for' => 'required_if:schedule,true|nullable|date|after:now',
        ]);

        // Get recipient IDs based on target type
        $recipientIds = $this->notificationService->getRecipientIds(
            $validated['target_type'],
            $validated['specific_users'] ?? null
        );

        if (empty($recipientIds)) {
            return back()->with('error', 'No recipients found for the selected target.');
        }

        // Prepare notification data
        $notificationData = [
            'title' => $validated['title'],
            'message' => $validated['message'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'sender_id' => auth()->id(),
            'action_url' => $validated['action_url'] ?? null,
            'action_text' => $validated['action_text'] ?? null,
            'scheduled_for' => $validated['schedule'] ? $validated['scheduled_for'] : null,
        ];

        // Create notifications
        $count = $this->notificationService->broadcast(
            $notificationData,
            $recipientIds,
            $validated['schedule'] ?? false
        );

        $message = $validated['schedule'] ?? false
            ? "Notification scheduled successfully for {$count} recipients."
            : "Notification sent successfully to {$count} recipients.";

        return redirect()->route('admin.notifications.index')->with('success', $message);
    }

    /**
     * Show notification details
     */
    public function show(Notification $notification)
    {
        $notification->load(['sender', 'recipient']);

        // Get all related notifications (same title/message sent to multiple users)
        $relatedNotifications = Notification::where('title', $notification->title)
            ->where('message', $notification->message)
            ->where('created_at', $notification->created_at)
            ->with('recipient')
            ->get();

        // Statistics for this notification
        $stats = [
            'total_sent' => $relatedNotifications->count(),
            'read_count' => $relatedNotifications->where('read_at', '!=', null)->count(),
            'unread_count' => $relatedNotifications->where('read_at', '=', null)->count(),
            'read_percentage' => $relatedNotifications->count() > 0 
                ? round(($relatedNotifications->where('read_at', '!=', null)->count() / $relatedNotifications->count()) * 100, 1)
                : 0,
        ];

        return view('admin.notifications.show', compact('notification', 'relatedNotifications', 'stats'));
    }

    /**
     * Delete notification
     */
    public function destroy(Notification $notification)
    {
        // Only allow deleting pending or scheduled notifications
        if ($notification->isSent() && !$notification->isScheduled()) {
            return back()->with('error', 'Cannot delete sent notifications.');
        }

        // Delete all related notifications (same broadcast)
        Notification::where('title', $notification->title)
            ->where('message', $notification->message)
            ->where('created_at', $notification->created_at)
            ->delete();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }

    /**
     * Analytics/Statistics page
     */
    public function analytics()
    {
        $stats = [
            // Overall statistics
            'total_notifications' => Notification::count(),
            'total_broadcast' => Notification::where('type', 'broadcast')->count(),
            'total_system' => Notification::where('type', 'system')->count(),
            'total_sent' => Notification::sent()->count(),
            'total_scheduled' => Notification::scheduled()->count(),
            'total_read' => Notification::read()->count(),
            'total_unread' => Notification::unread()->count(),

            // By priority
            'high_priority' => Notification::priority('high')->count(),
            'medium_priority' => Notification::priority('medium')->count(),
            'low_priority' => Notification::priority('low')->count(),

            // By category
            'by_category' => Notification::selectRaw('category, count(*) as count')
                ->groupBy('category')
                ->pluck('count', 'category'),

            // Recent activity (last 30 days)
            'recent_sent' => Notification::sent()
                ->where('sent_at', '>=', now()->subDays(30))
                ->count(),
            
            'recent_read' => Notification::read()
                ->where('read_at', '>=', now()->subDays(30))
                ->count(),

            // Read rate
            'overall_read_rate' => Notification::sent()->count() > 0
                ? round((Notification::read()->count() / Notification::sent()->count()) * 100, 1)
                : 0,
        ];

        // Daily activity for last 30 days
        $dailyActivity = Notification::selectRaw('DATE(created_at) as date, count(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top recipients (most notifications received)
        $topRecipients = Notification::selectRaw('recipient_id, count(*) as notification_count')
            ->groupBy('recipient_id')
            ->orderByDesc('notification_count')
            ->with('recipient:id,name,email')
            ->limit(10)
            ->get();

        return view('admin.notifications.analytics', compact('stats', 'dailyActivity', 'topRecipients'));
    }

    /**
     * Get notifications for topbar (API)
     */
    public function getNotifications(Request $request)
    {
        $notifications = $this->notificationService->getRecent(auth()->id(), 10);
        $unreadCount = $this->notificationService->getUnreadCount(auth()->id());

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        if ($notification->recipient_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
        ]);
    }

    /**
     * Mark all as read
     */
    public function markAllAsRead()
    {
        $count = $this->notificationService->markAllAsRead(auth()->id());

        return response()->json([
            'success' => true,
            'message' => "{$count} notifications marked as read",
            'count' => $count,
        ]);
    }
}