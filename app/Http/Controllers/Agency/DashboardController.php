<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Repositories\AgencyRepository;
use App\Models\Agency;
use App\Models\SubscriptionPlan;
use App\Models\AgencyDocumentRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected AgencyRepository $agencyRepository
    ) {}

    /**
     * Show the agency dashboard based on their status
     */
    public function index()
    {
        $user = Auth::user();
        $agency = $user->agency;

        // If no agency found, redirect to register
        if (!$agency) {
            return redirect()->route('register.agency')
                ->with('error', 'Please complete your agency registration.');
        }

        // CRITICAL: Check if onboarding is complete
        // If NOT complete, redirect to onboarding
        if (!$agency->onboarding_completed_at && $agency->status != "approved") {
            return redirect()->route('agency.onboarding.show', ['step' => 1])
                ->with('info', 'Please complete your onboarding process.');
        }

        // Route based on agency status (AFTER onboarding is complete)
        return match($agency->status) {
            'pending' => $this->showPendingView($agency),
            'rejected' => $this->showRejectedView($agency),
            'approved' => $this->showApprovedView($agency),
            'active' => $this->showActiveView($agency),
            'suspended' => $this->showSuspendedView($agency),
            default => $this->showPendingView($agency),
        };
    }

    /**
     * Pending - Waiting for admin approval
     */
    protected function showPendingView(Agency $agency)
    {
        return view('agency.status.pending', compact('agency'));
    }

    /**
     * Rejected - Show rejection reason
     */
    protected function showRejectedView(Agency $agency)
    {
        return view('agency.status.rejected', compact('agency'));
    }

    /**
     * Approved - Show subscription plans
     */
    protected function showApprovedView(Agency $agency)
    {
        // Check if documents are complete
        $documentRequirements = AgencyDocumentRequirement::where('agency_id', $agency->id)->get();
        $documentsComplete = $this->checkDocumentsComplete($agency);

        // Get subscription plans
        $plans = SubscriptionPlan::where('is_active', true)
            ->orderBy('price', 'asc')
            ->get();

        return view('agency.status.approved', compact('agency', 'plans', 'documentRequirements', 'documentsComplete'));
    }

    /**
     * Active - Full dashboard access
     */
    protected function showActiveView(Agency $agency)
    {
        // Get dashboard data
        $stats = [
            'total_agents' => $agency->agents()->count(),
            'active_agents' => $agency->agents()->whereHas('user', function($q) {
                $q->where('is_active', true);
            })->count(),
            'total_properties' => 0, // Will be implemented later
            'active_listings' => 0, // Will be implemented later
        ];

        // Get agents
        $agents = $agency->agents()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // Get subscription info
        $subscription = $agency->activeSubscription;

        return view('agency.dashboard', compact('agency', 'stats', 'agents', 'subscription'));
    }

    /**
     * Suspended - Show suspension message
     */
    protected function showSuspendedView(Agency $agency)
    {
        return view('agency.status.suspended', compact('agency'));
    }

    /**
     * Show documents page
     */
    public function documents()
    {
        $user = Auth::user();
        $agency = $user->agency;

        if (!$agency) {
            return redirect()->route('register.agency');
        }

        // Get all document requirements
        $documentRequirements = AgencyDocumentRequirement::where('agency_id', $agency->id)->get();

        // If no requirements exist, create them
        if ($documentRequirements->isEmpty()) {
            $this->createDocumentRequirements($agency);
            $documentRequirements = AgencyDocumentRequirement::where('agency_id', $agency->id)->get();
        }

        return view('agency.documents', compact('agency', 'documentRequirements'));
    }

    /**
     * Upload document
     */
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'requirement_id' => 'required|exists:agency_document_requirements,id',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        $user = Auth::user();
        $agency = $user->agency;

        $requirement = AgencyDocumentRequirement::where('id', $request->requirement_id)
            ->where('agency_id', $agency->id)
            ->firstOrFail();

        // Store the file
        $path = $request->file('document')->store('agency-documents/' . $agency->id, 'private');

        // Update the requirement
        $requirement->update([
            'file_path' => $path,
            'file_name' => $request->file('document')->getClientOriginalName(),
            'uploaded_at' => now(),
            'status' => 'pending_review',
        ]);

        return back()->with('success', 'Document uploaded successfully! It will be reviewed by our admin team.');
    }

    /**
     * Delete document
     */
    public function deleteDocument($id)
    {
        $user = Auth::user();
        $agency = $user->agency;

        $requirement = AgencyDocumentRequirement::where('id', $id)
            ->where('agency_id', $agency->id)
            ->firstOrFail();

        // Delete the file if exists
        if ($requirement->file_path && \Storage::disk('private')->exists($requirement->file_path)) {
            \Storage::disk('private')->delete($requirement->file_path);
        }

        // Reset the requirement
        $requirement->update([
            'file_path' => null,
            'file_name' => null,
            'uploaded_at' => null,
            'status' => 'pending',
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'Document deleted successfully.');
    }

    /**
     * Check if all required documents are uploaded
     */
    protected function checkDocumentsComplete(Agency $agency): bool
    {
        $requirements = AgencyDocumentRequirement::where('agency_id', $agency->id)->get();

        if ($requirements->isEmpty()) {
            return false;
        }

        $requiredCount = $requirements->where('is_required', true)->count();
        $uploadedCount = $requirements->where('is_required', true)
            ->whereNotNull('file_path')
            ->whereIn('status', ['pending_review', 'approved'])
            ->count();

        return $requiredCount === $uploadedCount;
    }

    /**
     * Create document requirements for agency
     */
    protected function createDocumentRequirements(Agency $agency)
    {
        $documents = [
            [
                'name' => 'Real Estate Agency License Certificate',
                'description' => 'Upload your valid Real Estate Agency License issued by your state/territory.',
                'is_required' => true,
            ],
            [
                'name' => 'Proof of Identity - Principal/Licensee',
                'description' => 'Upload a valid Passport or Driver License for the Principal/License Holder.',
                'is_required' => true,
            ],
            [
                'name' => 'ABN Registration Certificate',
                'description' => 'Upload your Australian Business Number (ABN) registration certificate.',
                'is_required' => true,
            ],
            [
                'name' => 'Professional Indemnity Insurance',
                'description' => 'Upload your current Professional Indemnity Insurance certificate.',
                'is_required' => true,
            ],
            [
                'name' => 'Public Liability Insurance',
                'description' => 'Upload your current Public Liability Insurance certificate.',
                'is_required' => true,
            ],
        ];

        foreach ($documents as $doc) {
            AgencyDocumentRequirement::create([
                'agency_id' => $agency->id,
                'name' => $doc['name'],
                'description' => $doc['description'],
                'is_required' => $doc['is_required'],
                'status' => 'pending',
            ]);
        }
    }

    public function newApplication(Request $request)
    {
        $user = Auth::user();
        $agency = $user->agency;

        if (!$agency) {
            return redirect()->route('register.agency');
        }

        // Reset agency status and onboarding
        $agency->update([
            'status' => 'pending',
            'onboarding_completed_at' => null,
            'rejection_reason' => null,
            'reviewed_at' => null,
        ]);

        // Delete existing document requirements
        AgencyDocumentRequirement::where('agency_id', $agency->id)->delete();

        return redirect()->route('agency.onboarding.show', ['step' => 1])
            ->with('success', 'You have started a new application. Please complete the onboarding process again.');

    }
}