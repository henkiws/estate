<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\User;
use App\Models\ActivityLog;
use App\Notifications\AgentInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AgentController extends Controller
{
    /**
     * Display listing of agents
     */
    public function index(Request $request)
    {
        $agency = Auth::user()->agency;
        
        $query = Agent::with('user')
            ->where('agency_id', $agency->id);
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('agent_code', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by employment type
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }
        
        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $agents = $query->paginate(12)->withQueryString();
        
        // Stats
        $stats = [
            'total' => Agent::where('agency_id', $agency->id)->count(),
            'active' => Agent::where('agency_id', $agency->id)->where('status', 'active')->count(),
            'inactive' => Agent::where('agency_id', $agency->id)->where('status', 'inactive')->count(),
            'on_leave' => Agent::where('agency_id', $agency->id)->where('status', 'on_leave')->count(),
        ];
        
        return view('agency.agents.index', compact('agents', 'stats', 'agency'));
    }

    /**
     * Show create agent form
     */
    public function create()
    {
        $agency = Auth::user()->agency;
        
        return view('agency.agents.create', compact('agency'));
    }

    /**
     * Store new agent
     */
    public function store(Request $request)
    {
        $agency = Auth::user()->agency;
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:agents,email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'license_number' => 'nullable|string|max:50',
            'license_expiry' => 'nullable|date|after:today',
            'position' => 'nullable|string|max:100',
            'employment_type' => 'required|in:full_time,part_time,contractor,intern',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'specializations' => 'nullable|array',
            'languages' => 'nullable|array',
            'address_line1' => 'nullable|string|max:255',
            'suburb' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:10',
            'postcode' => 'nullable|string|max:10',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:50',
            'started_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_accepting_new_listings' => 'boolean',
            'send_invitation' => 'boolean',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Handle photo upload
            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('agents', 'public');
            }
            
            // Create agent
            $agent = Agent::create(array_merge($validated, [
                'agency_id' => $agency->id,
                'status' => 'active',
            ]));
            
            // Create user account if sending invitation
            if ($request->boolean('send_invitation')) {
                $this->createUserAndSendInvitation($agent, $agency);
            }
            
            DB::commit();
            
            return redirect()
                ->route('agency.agents.show', $agent->id)
                ->with('success', 'Agent added successfully!' . 
                    ($request->boolean('send_invitation') ? ' Invitation email sent.' : ''));
                    
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to add agent. Please try again.');
        }
    }

    /**
     * Show agent profile
     */
    public function show(Agent $agent)
    {
        $agency = Auth::user()->agency;
        
        // Ensure agent belongs to this agency
        if ($agent->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to agent profile.');
        }
        
        $agent->load('user');
        
        // Get performance stats
        $stats = $agent->getPerformanceStats();
        
        // Get recent activities
        $activities = ActivityLog::where('subject_type', Agent::class)
            ->where('subject_id', $agent->id)
            ->latest()
            ->take(10)
            ->get();
        
        return view('agency.agents.show', compact('agent', 'stats', 'activities', 'agency'));
    }

    /**
     * Show edit form
     */
    public function edit(Agent $agent)
    {
        $agency = Auth::user()->agency;
        
        if ($agent->agency_id !== $agency->id) {
            abort(403);
        }
        
        return view('agency.agents.edit', compact('agent', 'agency'));
    }

    /**
     * Update agent
     */
    public function update(Request $request, Agent $agent)
    {
        $agency = Auth::user()->agency;
        
        if ($agent->agency_id !== $agency->id) {
            abort(403);
        }
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('agents')->ignore($agent->id)],
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'license_number' => 'nullable|string|max:50',
            'license_expiry' => 'nullable|date',
            'position' => 'nullable|string|max:100',
            'employment_type' => 'required|in:full_time,part_time,contractor,intern',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'specializations' => 'nullable|array',
            'languages' => 'nullable|array',
            'address_line1' => 'nullable|string|max:255',
            'suburb' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:10',
            'postcode' => 'nullable|string|max:10',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:50',
            'started_at' => 'nullable|date',
            'status' => 'required|in:active,inactive,on_leave,terminated',
            'is_featured' => 'boolean',
            'is_accepting_new_listings' => 'boolean',
        ]);
        
        try {
            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo
                if ($agent->photo) {
                    Storage::disk('public')->delete($agent->photo);
                }
                
                $validated['photo'] = $request->file('photo')->store('agents', 'public');
            }
            
            $agent->update($validated);
            
            return redirect()
                ->route('agency.agents.show', $agent->id)
                ->with('success', 'Agent updated successfully!');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update agent. Please try again.');
        }
    }

    /**
     * Delete agent
     */
    public function destroy(Agent $agent)
    {
        $agency = Auth::user()->agency;
        
        if ($agent->agency_id !== $agency->id) {
            abort(403);
        }
        
        try {
            // Check if agent has active listings
            $activeListings = $agent->listings()->count();
            
            if ($activeListings > 0) {
                return back()->with('error', 
                    "Cannot delete agent with {$activeListings} active listings. Please reassign or complete them first.");
            }
            
            // Delete photo
            if ($agent->photo) {
                Storage::disk('public')->delete($agent->photo);
            }
            
            // Deactivate user account
            if ($agent->user) {
                $agent->user->update(['is_active' => false]);
            }
            
            $agentName = $agent->full_name;
            $agent->delete();
            
            return redirect()
                ->route('agency.agents.index')
                ->with('success', "Agent {$agentName} has been deleted.");
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete agent. Please try again.');
        }
    }

    /**
     * Toggle agent status
     */
    public function toggleStatus(Agent $agent)
    {
        $agency = Auth::user()->agency;
        
        if ($agent->agency_id !== $agency->id) {
            abort(403);
        }
        
        $newStatus = $agent->status === 'active' ? 'inactive' : 'active';
        
        $agent->update(['status' => $newStatus]);
        
        if ($agent->user) {
            $agent->user->update(['is_active' => $newStatus === 'active']);
        }
        
        return back()->with('success', 
            "Agent {$agent->full_name} has been " . ($newStatus === 'active' ? 'activated' : 'deactivated') . '.');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Agent $agent)
    {
        $agency = Auth::user()->agency;
        
        if ($agent->agency_id !== $agency->id) {
            abort(403);
        }
        
        $agent->update(['is_featured' => !$agent->is_featured]);
        
        return back()->with('success', 
            'Featured status updated for ' . $agent->full_name . '.');
    }

    /**
     * Send/resend invitation to agent
     */
    public function sendInvitation(Agent $agent)
    {
        $agency = Auth::user()->agency;
        
        if ($agent->agency_id !== $agency->id) {
            abort(403);
        }
        
        try {
            if (!$agent->user) {
                $this->createUserAndSendInvitation($agent, $agency);
                $message = 'Invitation sent successfully!';
            } else {
                // Resend invitation
                $agent->user->notify(new AgentInvitation($agent, $agency));
                $message = 'Invitation resent successfully!';
            }
            
            return back()->with('success', $message);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send invitation. Please try again.');
        }
    }

    /**
     * Delete agent photo
     */
    public function deletePhoto(Agent $agent)
    {
        $agency = Auth::user()->agency;
        
        if ($agent->agency_id !== $agency->id) {
            abort(403);
        }
        
        if ($agent->photo) {
            Storage::disk('public')->delete($agent->photo);
            $agent->update(['photo' => null]);
        }
        
        return back()->with('success', 'Photo deleted successfully.');
    }

    /**
     * Create user account and send invitation
     */
    protected function createUserAndSendInvitation(Agent $agent, $agency)
    {
        // Create user account
        $user = User::create([
            'name' => $agent->full_name,
            'email' => $agent->email,
            'password' => Hash::make(Str::random(32)), // Random password
            'email_verified_at' => now(), // Pre-verify since agency is verified
            'is_active' => true,
        ]);
        
        // Assign agent role
        $user->assignRole('agent');
        
        // Link user to agent
        $agent->update(['user_id' => $user->id]);
        
        // Send invitation email
        $user->notify(new AgentInvitation($agent, $agency));
        
        ActivityLog::log(
            "Invitation sent to agent: {$agent->full_name}",
            $agency,
            ['agent_id' => $agent->id, 'email' => $agent->email]
        );
    }
}