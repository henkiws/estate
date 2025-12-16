<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AgencyRepository;
use App\Models\Agency;
use App\Models\AgencyDocumentRequirement;
use App\Models\ActivityLog;
use App\Mail\AgencyApproved;
use App\Mail\AgencyRejected;
use App\Mail\DocumentRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AgencyController extends Controller
{
    public function __construct(
        protected AgencyRepository $agencyRepository
    ) {}

    /**
     * Display a listing of agencies
     */
    public function index(Request $request)
    {
        // Get statistics
        $stats = $this->agencyRepository->getStatistics();
        
        // Build query
        $query = Agency::query()->with(['contacts', 'primaryContact']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('agency_name', 'like', "%{$search}%")
                  ->orWhere('trading_name', 'like', "%{$search}%")
                  ->orWhere('abn', 'like', "%{$search}%")
                  ->orWhere('business_email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by state
        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate
        $agencies = $query->paginate(15)->withQueryString();

        return view('admin.agencies.index', compact('agencies', 'stats'));
    }

    /**
     * Display the specified agency for review
     */
    public function show($id)
    {
        $agency = $this->agencyRepository->findWithAllRelations($id);
        
        // Get document requirements
        $documentRequirements = AgencyDocumentRequirement::where('agency_id', $id)
            ->orderBy('is_required', 'desc')
            ->orderBy('name', 'asc')
            ->get();
        
        // Get agents
        $agents = $agency->agents()->with('user')->get();
        
        // Get subscription info
        $subscription = $agency->activeSubscription;
        
        // Get recent transactions
        $transactions = $agency->transactions()
            ->with('subscriptionPlan')
            ->latest()
            ->take(10)
            ->get();

        // Get activity logs
        $activityLogs = ActivityLog::where('subject_type', Agency::class)
            ->where('subject_id', $id)
            ->with('causer')
            ->latest()
            ->take(20)
            ->get();

        return view('admin.agencies.show', compact(
            'agency',
            'documentRequirements',
            'agents',
            'subscription',
            'transactions',
            'activityLogs'
        ));
    }

    /**
     * Show the form for editing the specified agency
     */
    public function edit($id)
    {
        $agency = $this->agencyRepository->findWithAllRelations($id);

        return view('admin.agencies.edit', compact('agency'));
    }

    /**
     * Update the specified agency
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'agency_name' => 'required|string|max:255',
            'trading_name' => 'nullable|string|max:255',
            'abn' => 'required|string|size:11',
            'business_phone' => 'required|string|max:20',
            'business_email' => 'required|email|max:255',
            'status' => 'required|in:pending,approved,active,rejected,suspended,inactive',
        ]);

        try {
            $agency = Agency::findOrFail($id);
            $oldStatus = $agency->status;
            
            $this->agencyRepository->update($id, $request->all());

            // Log the update
            ActivityLog::log(
                "Agency information updated by admin",
                $agency->fresh(),
                [
                    'admin' => Auth::user()->name,
                    'admin_email' => Auth::user()->email,
                    'changes' => $request->only(['agency_name', 'status', 'business_email'])
                ]
            );

            // If status changed, log it separately
            if ($oldStatus !== $request->status) {
                ActivityLog::log(
                    "Agency status changed from {$oldStatus} to {$request->status}",
                    $agency->fresh(),
                    [
                        'admin' => Auth::user()->name,
                        'admin_email' => Auth::user()->email,
                        'old_status' => $oldStatus,
                        'new_status' => $request->status,
                        'changed_at' => now()->toDateTimeString(),
                    ]
                );
            }

            Log::info('Agency updated by admin', [
                'agency_id' => $id,
                'admin_id' => Auth::id(),
                'changes' => $request->all(),
            ]);

            return redirect()->route('admin.agencies.show', $id)
                ->with('success', 'Agency updated successfully!');

        } catch (\Exception $e) {
            Log::error('Agency update error: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Failed to update agency. Please try again.');
        }
    }

   /**
     * Approve the agency
     */
    public function approve($id)
    {
        try {
            $agency = Agency::findOrFail($id);
            $oldStatus = $agency->status;

            // Check if all required documents are approved
            $requiredDocs = AgencyDocumentRequirement::where('agency_id', $id)
                ->where('is_required', true)
                ->get();

            $allApproved = $requiredDocs->every(function($doc) {
                return $doc->status === 'approved';
            });

            if (!$allApproved) {
                return back()->with('error', 'Cannot approve agency. Not all required documents are approved.');
            }

            // Update status to 'approved' (waiting for subscription)
            $agency->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
                'rejection_reason' => null, // Clear any previous rejection
            ]);

            // Log the approval
            ActivityLog::log(
                "Agency approved by admin",
                $agency,
                [
                    'admin' => Auth::user()->name,
                    'admin_email' => Auth::user()->email,
                    'previous_status' => $oldStatus,
                    'new_status' => 'approved',
                    'approved_at' => now()->toDateTimeString(),
                ]
            );

            // Send approval email using queue
            try {
                Mail::to($agency->business_email)->queue(new AgencyApproved($agency));
                
                Log::info('Agency approval email queued', [
                    'agency_id' => $id,
                    'agency_email' => $agency->business_email,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to queue approval email', [
                    'agency_id' => $id,
                    'error' => $e->getMessage(),
                ]);
                // Don't fail the approval if email queuing fails
            }

            Log::info('Agency approved', [
                'agency_id' => $id,
                'agency_name' => $agency->agency_name,
                'admin_id' => Auth::id(),
                'admin_name' => Auth::user()->name,
            ]);

            return back()->with('success', 'Agency approved successfully! They can now choose a subscription plan.');

        } catch (\Exception $e) {
            Log::error('Agency approval error: ' . $e->getMessage());

            return back()->with('error', 'Failed to approve agency. Please try again.');
        }
    }

    /**
     * Reject the agency with reason
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:1000',
        ], [
            'rejection_reason.required' => 'Please provide a reason for rejection.',
            'rejection_reason.min' => 'Rejection reason must be at least 10 characters.',
        ]);

        try {
            $agency = Agency::findOrFail($id);
            $oldStatus = $agency->status;

            // Update status to rejected with reason
            $agency->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'rejected_at' => now(),
                'rejected_by' => Auth::id(),
            ]);

            // Log the rejection
            ActivityLog::log(
                "Agency rejected by admin",
                $agency,
                [
                    'admin' => Auth::user()->name,
                    'admin_email' => Auth::user()->email,
                    'previous_status' => $oldStatus,
                    'new_status' => 'rejected',
                    'rejection_reason' => $request->rejection_reason,
                    'rejected_at' => now()->toDateTimeString(),
                ]
            );

            // Send rejection email using queue
            try {
                Mail::to($agency->business_email)->queue(new AgencyRejected($agency));
                
                Log::info('Agency rejection email queued', [
                    'agency_id' => $id,
                    'agency_email' => $agency->business_email,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to queue rejection email', [
                    'agency_id' => $id,
                    'error' => $e->getMessage(),
                ]);
                // Don't fail the rejection if email queuing fails
            }

            Log::info('Agency rejected', [
                'agency_id' => $id,
                'agency_name' => $agency->agency_name,
                'admin_id' => Auth::id(),
                'admin_name' => Auth::user()->name,
                'reason' => $request->rejection_reason,
            ]);

            return back()->with('success', 'Agency rejected. They have been notified via email with the reason.');

        } catch (\Exception $e) {
            Log::error('Agency rejection error: ' . $e->getMessage());

            return back()->with('error', 'Failed to reject agency. Please try again.');
        }
    }

    /**
     * Suspend the agency
     */
    public function suspend(Request $request, $id)
    {
        $request->validate([
            'suspension_reason' => 'nullable|string|max:500',
        ]);

        try {
            $agency = Agency::findOrFail($id);
            $oldStatus = $agency->status;

            $agency->update([
                'status' => 'suspended',
                'suspended_at' => now(),
                'suspended_by' => Auth::id(),
            ]);

            // Log the suspension
            ActivityLog::log(
                "Agency suspended by admin",
                $agency,
                [
                    'admin' => Auth::user()->name,
                    'admin_email' => Auth::user()->email,
                    'previous_status' => $oldStatus,
                    'new_status' => 'suspended',
                    'suspension_reason' => $request->suspension_reason ?? 'No reason provided',
                    'suspended_at' => now()->toDateTimeString(),
                ]
            );

            Log::info('Agency suspended', [
                'agency_id' => $id,
                'admin_id' => Auth::id(),
                'reason' => $request->suspension_reason,
            ]);

            return back()->with('success', 'Agency suspended successfully.');

        } catch (\Exception $e) {
            Log::error('Agency suspension error: ' . $e->getMessage());

            return back()->with('error', 'Failed to suspend agency. Please try again.');
        }
    }

    /**
     * Reactivate the agency
     */
    public function reactivate($id)
    {
        try {
            $agency = Agency::findOrFail($id);
            $oldStatus = $agency->status;

            // Check if agency has active subscription
            $hasSubscription = $agency->activeSubscription !== null;

            $newStatus = $hasSubscription ? 'active' : 'approved';

            $agency->update([
                'status' => $newStatus,
                'suspended_at' => null,
                'suspended_by' => null,
            ]);

            // Log the reactivation
            ActivityLog::log(
                "Agency reactivated by admin",
                $agency,
                [
                    'admin' => Auth::user()->name,
                    'admin_email' => Auth::user()->email,
                    'previous_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'has_subscription' => $hasSubscription,
                    'reactivated_at' => now()->toDateTimeString(),
                ]
            );

            Log::info('Agency reactivated', [
                'agency_id' => $id,
                'admin_id' => Auth::id(),
                'new_status' => $newStatus,
            ]);

            return back()->with('success', 'Agency reactivated successfully.');

        } catch (\Exception $e) {
            Log::error('Agency reactivation error: ' . $e->getMessage());

            return back()->with('error', 'Failed to reactivate agency. Please try again.');
        }
    }

    /**
     * Remove the specified agency
     */
    public function destroy($id)
    {
        try {
            $agency = Agency::findOrFail($id);
            
            // Log before deletion
            ActivityLog::log(
                "Agency deleted by admin",
                $agency,
                [
                    'admin' => Auth::user()->name,
                    'admin_email' => Auth::user()->email,
                    'agency_name' => $agency->agency_name,
                    'agency_email' => $agency->business_email,
                    'agency_abn' => $agency->abn,
                    'deleted_at' => now()->toDateTimeString(),
                ]
            );

            $this->agencyRepository->delete($id);

            Log::info('Agency deleted', [
                'agency_id' => $id,
                'admin_id' => Auth::id(),
            ]);

            return redirect()->route('admin.agencies.index')
                ->with('success', 'Agency deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Agency deletion error: ' . $e->getMessage());

            return back()->with('error', 'Failed to delete agency. Please try again.');
        }
    }

    /**
     * Preview document in new tab
     */
    public function previewDocument($agencyId, $documentId)
    {
        try {
            $agency = Agency::findOrFail($agencyId);
            $document = AgencyDocumentRequirement::findOrFail($documentId);

            // Check if document belongs to agency
            if ($document->agency_id !== $agency->id) {
                abort(403, 'Unauthorized access to document');
            }

            // Check if file exists
            if (!$document->file_path || !Storage::disk('private')->exists($document->file_path)) {
                abort(404, 'Document file not found');
            }

            // Get file contents
            $file = Storage::disk('private')->get($document->file_path);
            $mimeType = $document->file_type ?? Storage::disk('private')->mimeType($document->file_path);

            // Return file with inline disposition (opens in browser)
            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="' . $document->file_name . '"');
                
        } catch (\Exception $e) {
            Log::error('Document preview failed', [
                'agency_id' => $agencyId,
                'document_id' => $documentId,
                'error' => $e->getMessage()
            ]);
            
            abort(500, 'Failed to preview document');
        }
    }

    /**
     * Download document
     */
    public function downloadDocument($agencyId, $documentId)
    {
        try {
            $agency = Agency::findOrFail($agencyId);
            $document = AgencyDocumentRequirement::findOrFail($documentId);

            // Check if document belongs to agency
            if ($document->agency_id !== $agency->id) {
                abort(403, 'Unauthorized access to document');
            }

            // Check if file exists
            if (!$document->file_path || !Storage::disk('private')->exists($document->file_path)) {
                abort(404, 'Document file not found');
            }

            // Return file as download
            return Storage::disk('private')->download(
                $document->file_path, 
                $document->file_name
            );
            
        } catch (\Exception $e) {
            Log::error('Document download failed', [
                'agency_id' => $agencyId,
                'document_id' => $documentId,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to download document. Please try again.');
        }
    }

    /**
     * Approve document
     */
    public function approveDocument($agencyId, $documentId)
    {
        try {
            $agency = Agency::findOrFail($agencyId);
            $document = AgencyDocumentRequirement::findOrFail($documentId);

            // Check if document belongs to agency
            if ($document->agency_id !== $agency->id) {
                return back()->with('error', 'Unauthorized access to document');
            }

            // Check if document has been uploaded
            if (!$document->file_path) {
                return back()->with('error', 'Cannot approve document that has not been uploaded');
            }

            // Update document status
            $document->update([
                'status' => 'approved',
                'reviewed_at' => now(),
                'reviewed_by' => Auth::id(),
                'rejection_reason' => null, // Clear any previous rejection
            ]);

            // Log the document approval
            ActivityLog::log(
                "Document approved: {$document->name}",
                $agency,
                [
                    'admin' => Auth::user()->name,
                    'admin_email' => Auth::user()->email,
                    'document_id' => $document->id,
                    'document_name' => $document->name,
                    'document_type' => $document->document_type,
                    'file_name' => $document->file_name,
                    'action' => 'approved',
                    'reviewed_at' => now()->toDateTimeString(),
                ]
            );

            Log::info('Document approved', [
                'agency_id' => $agency->id,
                'document_id' => $document->id,
                'admin_id' => Auth::id(),
            ]);

            return back()->with('success', "Document '{$document->name}' approved successfully!");
            
        } catch (\Exception $e) {
            Log::error('Document approval failed', [
                'error' => $e->getMessage(),
                'agency_id' => $agencyId,
                'document_id' => $documentId,
            ]);
            
            return back()->with('error', 'Failed to approve document. Please try again.');
        }
    }

    /**
     * Reject document with reason
     */
    public function rejectDocument(Request $request, $agencyId, $documentId)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500',
        ], [
            'rejection_reason.required' => 'Please provide a reason for rejection.',
            'rejection_reason.min' => 'Rejection reason must be at least 10 characters.',
        ]);

        try {
            $agency = Agency::findOrFail($agencyId);
            $document = AgencyDocumentRequirement::findOrFail($documentId);

            // Check if document belongs to agency
            if ($document->agency_id !== $agency->id) {
                return back()->with('error', 'Unauthorized access to document');
            }

            // Update document status
            $document->update([
                'status' => 'rejected',
                'reviewed_at' => now(),
                'reviewed_by' => Auth::id(),
                'rejection_reason' => $request->rejection_reason,
            ]);

            // Log the document rejection
            ActivityLog::log(
                "Document rejected: {$document->name}",
                $agency,
                [
                    'admin' => Auth::user()->name,
                    'admin_email' => Auth::user()->email,
                    'document_id' => $document->id,
                    'document_name' => $document->name,
                    'document_type' => $document->document_type,
                    'file_name' => $document->file_name,
                    'action' => 'rejected',
                    'rejection_reason' => $request->rejection_reason,
                    'reviewed_at' => now()->toDateTimeString(),
                ]
            );

            // Send email notification to agency
            try {
                Mail::to($agency->business_email)->send(new DocumentRejected($agency, $document));
            } catch (\Exception $e) {
                Log::error('Failed to send document rejection email: ' . $e->getMessage());
            }

            Log::info('Document rejected', [
                'agency_id' => $agency->id,
                'document_id' => $document->id,
                'admin_id' => Auth::id(),
                'reason' => $request->rejection_reason,
            ]);

            return back()->with('success', "Document '{$document->name}' rejected. Agency has been notified.");
            
        } catch (\Exception $e) {
            Log::error('Document rejection failed', [
                'error' => $e->getMessage(),
                'agency_id' => $agencyId,
                'document_id' => $documentId,
            ]);
            
            return back()->with('error', 'Failed to reject document. Please try again.');
        }
    }

    /**
     * Get pending agencies count (API endpoint)
     */
    public function getPendingCount()
    {
        $count = Agency::where('status', 'pending')->count();

        return response()->json(['count' => $count]);
    }
}