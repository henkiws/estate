<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    /**
     * Display list of agency's support tickets
     */
    public function index(Request $request)
    {
        $query = SupportTicket::with(['replies'])
            ->where('user_id', Auth::id())
            ->where('user_type', 'agency');
        
        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
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
            default: // recent
                $query->orderBy('created_at', 'desc');
        }
        
        $tickets = $query->paginate(15)->appends($request->except('page'));
        
        // Get counts for filters
        $counts = [
            'all' => SupportTicket::where('user_id', Auth::id())->where('user_type', 'agency')->count(),
            'open' => SupportTicket::where('user_id', Auth::id())->where('user_type', 'agency')->where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('user_id', Auth::id())->where('user_type', 'agency')->where('status', 'in_progress')->count(),
            'waiting_response' => SupportTicket::where('user_id', Auth::id())->where('user_type', 'agency')->where('status', 'waiting_response')->count(),
            'resolved' => SupportTicket::where('user_id', Auth::id())->where('user_type', 'agency')->where('status', 'resolved')->count(),
            'closed' => SupportTicket::where('user_id', Auth::id())->where('user_type', 'agency')->where('status', 'closed')->count(),
        ];
        
        return view('agency.support.index', compact('tickets', 'counts'));
    }
    
    /**
     * Show the form for creating a new ticket
     */
    public function create()
    {
        return view('agency.support.create');
    }
    
    /**
     * Store a new support ticket
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'required|in:billing,subscription,agent_management,property_listing,technical,account,other',
            'priority' => 'required|in:low,medium,high,critical',
            'message' => 'required|string|min:10',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);
        
        // Create ticket
        $ticket = SupportTicket::create([
            'ticket_number' => SupportTicket::generateTicketNumber(),
            'user_id' => Auth::id(),
            'user_type' => 'agency',
            'subject' => $request->subject,
            'category' => $request->category,
            'priority' => $request->priority,
            'message' => $request->message,
            'status' => 'open',
        ]);
        
        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('support-tickets/' . $ticket->id, 'public');
                
                $ticket->attachments()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }
        
        return redirect()
            ->route('agency.support.show', $ticket)
            ->with('success', 'Support ticket created successfully. Our team will respond shortly.');
    }
    
    /**
     * Display a specific ticket
     */
    public function show(SupportTicket $ticket)
    {
        // Make sure ticket belongs to agency
        if ($ticket->user_id !== Auth::id() || $ticket->user_type !== 'agency') {
            abort(403, 'Unauthorized access to this ticket.');
        }
        
        $ticket->load(['replies.user', 'attachments']);
        
        return view('agency.support.show', compact('ticket'));
    }
    
    /**
     * Reply to a ticket
     */
    public function reply(Request $request, SupportTicket $ticket)
    {
        // Make sure ticket belongs to agency
        if ($ticket->user_id !== Auth::id() || $ticket->user_type !== 'agency') {
            abort(403, 'Unauthorized access to this ticket.');
        }
        
        // Don't allow replies to closed tickets
        if ($ticket->status === 'closed') {
            return back()->with('error', 'Cannot reply to a closed ticket.');
        }
        
        $request->validate([
            'message' => 'required|string|min:5',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);
        
        // Create reply
        $reply = SupportTicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_staff_reply' => false,
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
        
        // Update ticket status
        if ($ticket->status === 'waiting_response') {
            $ticket->update(['status' => 'in_progress']);
        }
        
        return back()->with('success', 'Reply added successfully.');
    }
    
    /**
     * Close a ticket
     */
    public function close(SupportTicket $ticket)
    {
        // Make sure ticket belongs to agency
        if ($ticket->user_id !== Auth::id() || $ticket->user_type !== 'agency') {
            abort(403, 'Unauthorized access to this ticket.');
        }
        
        $ticket->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);
        
        return back()->with('success', 'Ticket closed successfully.');
    }
}