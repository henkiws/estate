<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\AgencyDocument;
use App\Models\AgencyBranding;
use App\Models\AgencyContact;

class AgencyProfileController extends Controller
{
    /**
     * Show the agency profile edit form
     */
    public function edit()
    {
        $agency = Auth::user()->agency->load('documentRequirements', 'documents', 'branding', 'contacts');
        
        // Get license and insurance documents
        $licenseDocument = $agency->documents()->where('document_type', 'license_certificate')->first();
        $insuranceDocument = $agency->documents()->where('document_type', 'other')->first();
        
        // Get primary contact or first contact
        $agencyContact = $agency->contacts()->where('is_primary', true)->first() 
                      ?? $agency->contacts()->first();
        
        // Get branding or create empty instance
        $agencyBranding = $agency->branding ?? new AgencyBranding();
        
        return view('agency.profile.edit', compact(
            'agency', 
            'licenseDocument', 
            'insuranceDocument',
            'agencyContact',
            'agencyBranding'
        ));
    }

    /**
     * Update the agency profile
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $agency = Auth::user()->agency;

            $validated = $request->validate([
                // Company Information (Agency Model)
                'trading_name' => 'nullable|string|max:255',
                'business_type' => 'required|in:sole_trader,partnership,company,trust',
                'description' => 'nullable|string|max:1000',
                'license_number' => 'required|string|max:50',
                'license_holder_name' => 'required|string|max:255',
                'license_expiry_date' => 'required|date|after:today',
                
                // Company Details (Agency Model - business contact info)
                'business_address' => 'required|string|max:500',
                'state' => 'required|string|max:50',
                'postcode' => 'required|string|max:10',
                'business_phone' => 'required|string|max:20',
                'business_email' => 'required|email|max:255',
                'website_url' => 'nullable|url|max:255',
                
                // Contact Details (AgencyContact Model - contact person)
                'contact_full_name' => 'nullable|string|max:255',
                'contact_position' => 'nullable|string|max:255',
                'contact_email' => 'nullable|email|max:255',
                'contact_phone' => 'nullable|string|max:20',
                'contact_mobile' => 'nullable|string|max:20',
                
                // Branding (AgencyBranding Model)
                'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                
                // Social Media (AgencyBranding Model)
                'facebook_url' => 'nullable|url|max:255',
                'linkedin_url' => 'nullable|url|max:255',
                'instagram_url' => 'nullable|url|max:255',
                'twitter_url' => 'nullable|url|max:255',
                
                // Document Uploads (AgencyDocument Model)
                'license_attachment' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:5120', // 5MB
                'insurance_attachment' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:5120', // 5MB
            ], [
                'license_expiry_date.after' => 'License expiry date must be in the future',
                'logo.max' => 'Logo file size must not exceed 2MB',
                'license_attachment.max' => 'License attachment must not exceed 5MB',
                'license_attachment.mimes' => 'License attachment must be a PDF, JPG, JPEG, or PNG file',
                'insurance_attachment.max' => 'Insurance attachment must not exceed 5MB',
                'insurance_attachment.mimes' => 'Insurance attachment must be a PDF, JPG, JPEG, or PNG file',
            ]);

            // ==========================================
            // 1. Update Agency Model (Company Info + Company Details)
            // ==========================================
            $agency->update([
                // Company Info
                'trading_name' => $validated['trading_name'],
                'business_type' => $validated['business_type'],
                'description' => $validated['description'],
                'license_number' => $validated['license_number'],
                'license_holder_name' => $validated['license_holder_name'],
                'license_expiry_date' => $validated['license_expiry_date'],
                
                // Company Details (business contact info)
                'business_address' => $validated['business_address'],
                'state' => $validated['state'],
                'postcode' => $validated['postcode'],
                'business_phone' => $validated['business_phone'],
                'business_email' => $validated['business_email'],
            ]);

            // ==========================================
            // 2. Update/Create AgencyContact (Contact Person Details)
            // ==========================================
            $contactData = [
                'full_name' => $validated['contact_full_name'],
                'position' => $validated['contact_position'],
                'email' => $validated['contact_email'],
                'phone' => $validated['contact_phone'],
                'mobile' => $validated['contact_mobile'],
            ];

            // Get primary contact or first contact
            $agencyContact = $agency->contacts()->where('is_primary', true)->first() 
                          ?? $agency->contacts()->first();

            if ($agencyContact) {
                // Update existing contact
                $agencyContact->update($contactData);
            } else {
                // Create new primary contact
                $agency->contacts()->create(array_merge($contactData, [
                    'is_primary' => true,
                    'user_id' => Auth::id(),
                ]));
            }

            // ==========================================
            // 3. Update/Create AgencyBranding (Branding + Social Media)
            // ==========================================
            $brandingData = [
                'facebook_url' => $validated['facebook_url'],
                'linkedin_url' => $validated['linkedin_url'],
                'instagram_url' => $validated['instagram_url'],
                'twitter_url' => $validated['twitter_url'],
                'website_url' => $validated['website_url'] ?? null,
            ];

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $agencyBranding = $agency->branding;
                
                // Delete old logo if exists
                if ($agencyBranding && $agencyBranding->logo_path) {
                    Storage::disk('public')->delete($agencyBranding->logo_path);
                }
                
                // Store new logo
                $path = $request->file('logo')->store('agencies/logos', 'public');
                $brandingData['logo_path'] = $path;
            }

            // Update or create branding
            AgencyBranding::updateOrCreate(
                ['agency_id' => $agency->id],
                $brandingData
            );

            // ==========================================
            // 4. Handle Document Uploads (AgencyDocument)
            // ==========================================
            
            // Handle License Attachment
            if ($request->hasFile('license_attachment')) {
                $this->handleDocumentUpload(
                    $agency, 
                    $request->file('license_attachment'), 
                    'license_certificate',
                    'License Certificate',
                    $validated['license_expiry_date'] ?? null
                );
            }

            // Handle Insurance Attachment
            if ($request->hasFile('insurance_attachment')) {
                $this->handleDocumentUpload(
                    $agency, 
                    $request->file('insurance_attachment'), 
                    'other',
                    'Insurance Certificate'
                );
            }

            DB::commit();
            return redirect()->route('agency.profile.edit')->with('success', 'Profile updated successfully!');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('agency.profile.edit')->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    /**
     * Handle document upload
     */
    private function handleDocumentUpload($agency, $file, $documentType, $documentName, $expiryDate = null)
    {
        // Find existing document
        $document = AgencyDocument::where('agency_id', $agency->id)
            ->where('document_type', $documentType)
            ->first();

        // Delete old file if exists
        if ($document && $document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Store new file
        $path = $file->store('agencies/documents', 'public');
        
        // Get file info
        $fileType = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();

        // Create or update document
        AgencyDocument::updateOrCreate(
            [
                'agency_id' => $agency->id,
                'document_type' => $documentType,
            ],
            [
                'document_name' => $documentName,
                'file_path' => $path,
                'file_type' => $fileType,
                'file_size' => $fileSize,
                'status' => 'pending', // Can be verified later by admin
                'expiry_date' => $expiryDate,
            ]
        );
    }

    /**
     * Delete agency logo from branding
     */
    public function deleteLogo()
    {
        $agency = Auth::user()->agency;
        $branding = $agency->branding;

        if ($branding && $branding->logo_path) {
            Storage::disk('public')->delete($branding->logo_path);
            $branding->update(['logo_path' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logo deleted successfully'
        ]);
    }

    /**
     * Delete license attachment
     */
    public function deleteLicenseAttachment()
    {
        try {
            $agency = Auth::user()->agency;
            
            $document = AgencyDocument::where('agency_id', $agency->id)
                ->where('document_type', 'license_certificate')
                ->first();

            if ($document) {
                // Delete file from storage
                if ($document->file_path) {
                    Storage::disk('public')->delete($document->file_path);
                }
                
                // Delete database record
                $document->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'License attachment deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete license attachment'
            ], 500);
        }
    }

    /**
     * Delete insurance attachment
     */
    public function deleteInsuranceAttachment()
    {
        try {
            $agency = Auth::user()->agency;
            
            $document = AgencyDocument::where('agency_id', $agency->id)
                ->where('document_type', 'other')
                ->first();

            if ($document) {
                // Delete file from storage
                if ($document->file_path) {
                    Storage::disk('public')->delete($document->file_path);
                }
                
                // Delete database record
                $document->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Insurance attachment deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete insurance attachment'
            ], 500);
        }
    }
}