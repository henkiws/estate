<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupportController extends Controller
{
    /**
     * Display all support tickets (admin view)
     */
    public function index(Request $request)
    {
        $query = SupportTicket::with(['user', 'replies', 'assignedTo']);
        
        // Filter by user type
        if ($request->filled('user_type') && $request->user_type !== 'all') {
            $query->where('user_type', $request->user_type);
        }
        
        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        
        // Filter by priority
        if ($request->filled('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }
        
        // Filter by assigned staff
        if ($request->filled('assigned_to') && $request->assigned_to !== 'all') {
            if ($request->assigned_to === 'unassigned') {
                $query->whereNull('assigned_to');
            } else {
                $query->where('assigned_to', $request->assigned_to);
            }
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        // Sort
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'updated':
                $query->orderBy('updated_at', 'desc');
                break;
            case 'priority':
                $query->orderByRaw("FIELD(priority, 'critical', 'urgent', 'high', 'medium', 'low')");
                break;
            default: // recent
                $query->orderBy('created_at', 'desc');
        }
        
        $tickets = $query->paginate(20)->appends($request->except('page'));
        
        // Get counts for filters
        $counts = [
            'all' => SupportTicket::count(),
            'user' => SupportTicket::where('user_type', 'user')->count(),
            'agency' => SupportTicket::where('user_type', 'agency')->count(),
            'open' => SupportTicket::where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'waiting_response' => SupportTicket::where('status', 'waiting_response')->count(),
            'resolved' => SupportTicket::where('status', 'resolved')->count(),
            'closed' => SupportTicket::where('status', 'closed')->count(),
            'unassigned' => SupportTicket::whereNull('assigned_to')->count(),
        ];
        
        // Get staff members for assignment dropdown (all admin users)
        // Adjust this query based on your user table structure
        // Option 1: If you have an 'is_admin' column
        // $staffMembers = User::where('is_admin', true)->orderBy('name')->get();
        
        // Option 2: If you check by email domain or specific IDs
        // $staffMembers = User::whereIn('id', [1, 2, 3])->orderBy('name')->get();
        
        // Option 3: Get all users (temporary - you should add proper admin identification)
        $staffMembers = User::orderBy('name')->limit(20)->get();
        
        return view('admin.support.index', compact('tickets', 'counts', 'staffMembers'));
    }
    
    /**
     * Display analytics dashboard
     */
    public function analytics()
    {
        // Overall statistics
        $stats = [
            'total_tickets' => SupportTicket::count(),
            'open_tickets' => SupportTicket::where('status', 'open')->count(),
            'resolved_today' => SupportTicket::where('status', 'resolved')
                                           ->whereDate('resolved_at', today())
                                           ->count(),
            'avg_response_time' => $this->calculateAverageResponseTime(),
        ];
        
        // Tickets by status
        $ticketsByStatus = SupportTicket::select('status', DB::raw('count(*) as count'))
                                       ->groupBy('status')
                                       ->get()
                                       ->pluck('count', 'status');
        
        // Tickets by priority
        $ticketsByPriority = SupportTicket::select('priority', DB::raw('count(*) as count'))
                                         ->groupBy('priority')
                                         ->get()
                                         ->pluck('count', 'priority');
        
        // Tickets by category
        $ticketsByCategory = SupportTicket::select('category', DB::raw('count(*) as count'))
                                         ->groupBy('category')
                                         ->get()
                                         ->pluck('count', 'category');
        
        // Tickets by user type
        $ticketsByUserType = SupportTicket::select('user_type', DB::raw('count(*) as count'))
                                         ->groupBy('user_type')
                                         ->get()
                                         ->pluck('count', 'user_type');
        
        // Recent activity (last 30 days)
        $recentActivity = SupportTicket::select(
                            DB::raw('DATE(created_at) as date'),
                            DB::raw('count(*) as count')
                          )
                          ->where('created_at', '>=', now()->subDays(30))
                          ->groupBy('date')
                          ->orderBy('date')
                          ->get();
        
        // Staff performance - Adjust based on your user structure
        // Option 1: If you have 'is_admin' column
        // $staffPerformance = User::where('is_admin', true)
        
        // Option 2: Get users who have assigned tickets
        $staffPerformance = User::whereHas('assignedTickets')
                               ->withCount(['assignedTickets', 'assignedTickets as resolved_count' => function($query) {
                                   $query->where('status', 'resolved');
                               }])
                               ->get();
        
        return view('admin.support.analytics', compact(
            'stats',
            'ticketsByStatus',
            'ticketsByPriority',
            'ticketsByCategory',
            'ticketsByUserType',
            'recentActivity',
            'staffPerformance'
        ));
    }
    
    /**
     * Display a specific ticket (admin view)
     */
    public function show(SupportTicket $ticket)
    {
        $ticket->load(['user', 'replies.user', 'attachments', 'assignedTo']);
        
        // Get staff members for assignment - adjust based on your structure
        $staffMembers = User::orderBy('name')->limit(20)->get();
        
        return view('admin.support.show', compact('ticket', 'staffMembers'));
    }
    
    /**
     * Reply to a ticket (as staff)
     */
    public function reply(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'message' => 'required|string|min:5',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);
        
        // Create reply as staff
        $reply = SupportTicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_staff_reply' => true,
        ]);
        
        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('support-tickets/' . $ticket->id . '/replies', 'public');
                
                $ticket->attachments()->create([
                    'reply_id' => $reply->id,
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }
        
        // Update ticket status if needed
        if ($ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);
        }
        
        return back()->with('success', 'Reply added successfully.');
    }
    
    /**
     * Update ticket status
     */
    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,waiting_response,resolved,closed',
        ]);
        
        $updateData = ['status' => $request->status];
        
        // Set resolved_at timestamp
        if ($request->status === 'resolved' && !$ticket->resolved_at) {
            $updateData['resolved_at'] = now();
        }
        
        // Set closed_at timestamp
        if ($request->status === 'closed' && !$ticket->closed_at) {
            $updateData['closed_at'] = now();
        }
        
        $ticket->update($updateData);
        
        return back()->with('success', 'Ticket status updated successfully.');
    }
    
    /**
     * Update ticket priority
     */
    public function updatePriority(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'priority' => 'required|in:low,medium,high,urgent,critical',
        ]);
        
        $ticket->update(['priority' => $request->priority]);
        
        return back()->with('success', 'Ticket priority updated successfully.');
    }
    
    /**
     * Assign ticket to staff member
     */
    public function assign(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        
        $ticket->update(['assigned_to' => $request->assigned_to]);
        
        $message = $request->assigned_to 
            ? 'Ticket assigned successfully.' 
            : 'Ticket unassigned successfully.';
        
        return back()->with('success', $message);
    }
    
    /**
     * Calculate average response time
     */
    private function calculateAverageResponseTime()
    {
        $tickets = SupportTicket::whereNotNull('resolved_at')
                                ->where('created_at', '>=', now()->subDays(30))
                                ->get();
        
        if ($tickets->isEmpty()) {
            return 'N/A';
        }
        
        $totalHours = 0;
        foreach ($tickets as $ticket) {
            $totalHours += $ticket->created_at->diffInHours($ticket->resolved_at);
        }
        
        $avgHours = round($totalHours / $tickets->count(), 1);
        
        return $avgHours . ' hours';
    }
}