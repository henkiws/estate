<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\AgencyDocumentRequirement;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class OnboardingController extends Controller
{
    /**
     * Show onboarding step
     */
    public function show($step = 1)
    {
        $user = Auth::user();
        $agency = $user->agency;

        // If agency doesn't exist, redirect
        if (!$agency) {
            return redirect()->route('agency.dashboard');
        }

        // If onboarding already completed or approved/active, redirect to dashboard
        if ($agency->onboarding_completed_at || in_array($agency->status, ['approved', 'active'])) {
            return redirect()->route('agency.dashboard')
                ->with('info', 'Your onboarding is already complete.');
        }

        // Validate step number (only 1 or 2)
        $step = (int) $step;
        if ($step < 1 || $step > 2) {
            return redirect()->route('agency.onboarding', ['step' => 1]);
        }

        // Get data based on step
        $data = $this->getStepData($agency, $step);

        return view('agency.onboarding.step' . $step, array_merge([
            'currentStep' => $step,
            'agency' => $agency,
        ], $data));
    }

    /**
     * Get data for specific step
     */
    protected function getStepData($agency, $step)
    {
        switch ($step) {
            case 1:
                // Welcome step - no additional data needed
                return [];
            
            case 2:
                // Document upload step
                $documents = AgencyDocumentRequirement::where('agency_id', $agency->id)
                    ->orderBy('is_required', 'desc')
                    ->orderBy('name', 'asc')
                    ->get();
                
                // AUTO-CREATE documents if they don't exist (for old agencies)
                if ($documents->isEmpty()) {
                    Log::info('Auto-creating document requirements for agency', ['agency_id' => $agency->id]);
                    $this->createDocumentRequirements($agency);
                    $documents = AgencyDocumentRequirement::where('agency_id', $agency->id)
                        ->orderBy('is_required', 'desc')
                        ->orderBy('name', 'asc')
                        ->get();
                }
                
                $uploadedCount = $documents->whereNotNull('file_path')->count();
                $requiredCount = $documents->where('is_required', true)->count();
                $progress = $requiredCount > 0 ? round(($uploadedCount / $requiredCount) * 100) : 0;
                
                return [
                    'documents' => $documents,
                    'uploadedCount' => $uploadedCount,
                    'requiredCount' => $requiredCount,
                    'progress' => $progress,
                ];
            
            default:
                return [];
        }
    }

    /**
     * Handle step 1 (Welcome - just proceed)
     */
    public function completeStep1()
    {
        return redirect()->route('agency.onboarding', ['step' => 2])
            ->with('success', 'Let\'s upload your required documents!');
    }

    /**
     * Handle step 2 (Upload Document)
     */
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:agency_document_requirements,id',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        try {
            $document = AgencyDocumentRequirement::where('id', $request->document_id)
                ->where('agency_id', Auth::user()->agency->id)
                ->firstOrFail();

            // Delete old file if exists
            if ($document->file_path) {
                Storage::disk('private')->delete($document->file_path);
            }

            // Store new file
            $file = $request->file('file');
            $path = $file->store('agency-documents/' . Auth::user()->agency->id, 'private');

            // Update document record
            $document->update([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'status' => 'pending_review',
                'uploaded_at' => now(),
            ]);

            // Log activity
            ActivityLog::log(
                "Document uploaded: {$document->name}",
                Auth::user()->agency,
                [
                    'document_name' => $document->name,
                    'file_name' => $file->getClientOriginalName(),
                ]
            );

            Log::info('Document uploaded', [
                'agency_id' => Auth::user()->agency->id,
                'document_id' => $document->id,
                'file_name' => $file->getClientOriginalName(),
            ]);

            // Calculate updated progress
            $agency = Auth::user()->agency;
            $allDocs = AgencyDocumentRequirement::where('agency_id', $agency->id)->get();
            $uploadedCount = $allDocs->whereNotNull('file_path')->count();
            $requiredCount = $allDocs->where('is_required', true)->count();

            return redirect()->route('agency.onboarding.show', ['step' => 2])
                ->with('success', "✓ {$document->name} uploaded successfully! ({$uploadedCount}/{$requiredCount} documents completed)");

        } catch (\Exception $e) {
            Log::error('Document upload failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to upload document. Please try again.');
        }
    }

    /**
     * Delete document
     */
    public function deleteDocument($id)
    {
        try {
            $document = AgencyDocumentRequirement::where('id', $id)
                ->where('agency_id', Auth::user()->agency->id)
                ->firstOrFail();

            // Can't delete if already approved
            if ($document->status === 'approved') {
                return back()->with('error', 'Cannot delete approved documents.');
            }

            // Delete file from storage
            if ($document->file_path) {
                Storage::disk('private')->delete($document->file_path);
            }

            // Reset document
            $document->update([
                'file_path' => null,
                'file_name' => null,
                'file_type' => null,
                'file_size' => null,
                'status' => 'pending',
                'uploaded_at' => null,
                'rejection_reason' => null,
            ]);

            // Log activity
            ActivityLog::log(
                "Document removed: {$document->name}",
                Auth::user()->agency,
                ['document_name' => $document->name]
            );

            return back()->with('success', 'Document deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Document deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete document. Please try again.');
        }
    }

    /**
     * Complete step 2 (Submit for Admin Approval)
     */
    public function submitForApproval()
    {
        $agency = Auth::user()->agency;
        
        // Check if all required documents are uploaded
        $documents = AgencyDocumentRequirement::where('agency_id', $agency->id)
            ->where('is_required', true)
            ->get();

        $uploadedCount = $documents->whereNotNull('file_path')->count();
        $requiredCount = $documents->count();

        if ($uploadedCount < $requiredCount) {
            return back()->with('error', 'Please upload all required documents before submitting.');
        }

        // Mark onboarding as complete
        $agency->update([
            'onboarding_completed_at' => now(),
            'status' => 'pending', // Status remains pending for admin review
        ]);

        // Log activity
        ActivityLog::log(
            "Agency completed onboarding - awaiting admin approval",
            $agency,
            [
                'documents_uploaded' => $uploadedCount,
                'completed_at' => now()->toDateTimeString(),
            ]
        );

        Log::info('Agency completed onboarding', [
            'agency_id' => $agency->id,
            'agency_name' => $agency->agency_name,
        ]);

        return redirect()->route('agency.dashboard')
            ->with('success', 'Documents submitted successfully! Your application is now pending admin review. You will receive an email once your agency is approved.');
    }

    /**
     * Skip onboarding (not recommended)
     */
    public function skip()
    {
        return redirect()->route('agency.dashboard')
            ->with('info', 'You can complete your document upload anytime from the dashboard.');
    }

    /**
     * Create document requirements for agency
     */
    protected function createDocumentRequirements($agency)
    {
        $documents = [
            [
                'name' => 'Real Estate Agency License Certificate',
                'description' => 'Valid real estate agency license issued by your state regulatory authority',
                'is_required' => true,
            ],
            [
                'name' => 'Proof of Identity - Principal/Licensee',
                'description' => 'Driver\'s license, passport, or other government-issued ID of the principal licensee',
                'is_required' => true,
            ],
            [
                'name' => 'ABN Registration Certificate',
                'description' => 'Australian Business Number registration document from the ATO',
                'is_required' => true,
            ],
            [
                'name' => 'Professional Indemnity Insurance',
                'description' => 'Current professional indemnity insurance certificate of currency',
                'is_required' => true,
            ],
            [
                'name' => 'Public Liability Insurance',
                'description' => 'Current public liability insurance certificate of currency',
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

        Log::info('Document requirements created for agency', [
            'agency_id' => $agency->id,
            'document_count' => count($documents),
        ]);
    }
}