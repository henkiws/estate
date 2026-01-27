<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\AddressReferenceThankYou;

class AddressReferenceController extends Controller
{
    /**
     * Show the reference form
     */
    public function show($token)
    {
        $address = UserAddress::where('reference_token', $token)->firstOrFail();
        
        // Check if already submitted (but still allow viewing)
        $alreadySubmitted = $address->referenceSubmitted();
        
        return view('address-reference.form', compact('address', 'alreadySubmitted'));
    }

    /**
     * Save as draft
     */
    public function saveDraft(Request $request, $token)
    {
        $address = UserAddress::where('reference_token', $token)->firstOrFail();
        
        // Don't allow editing if already submitted
        if ($address->referenceSubmitted()) {
            return response()->json([
                'success' => false,
                'message' => 'This reference has already been submitted.'
            ], 400);
        }
        
        // Save all fields (no validation for draft)
        $this->updateAddressReference($address, $request, true);
        
        return response()->json([
            'success' => true,
            'message' => 'Draft saved successfully!'
        ]);
    }

    /**
     * Submit reference
     */
    public function submit(Request $request, $token)
    {
        $address = UserAddress::where('reference_token', $token)->firstOrFail();
    
        // Don't allow resubmission
        if ($address->referenceSubmitted()) {
            return redirect()->route('address-reference.form', $token)
                ->with('error', 'This reference has already been submitted.');
        }
        
        // Validate required fields
        $validated = $request->validate([
            'ref_is_leaseholder' => 'required|in:yes,no,n/a',
            'ref_would_rent_again' => 'required|in:yes,no,n/a',
            'ref_lived_at_address' => 'required|in:yes,no,n/a',
            'ref_rent_paid_on_time' => 'required|in:yes,no,n/a',
            'ref_full_bond_refund' => 'required|in:yes,no,n/a',
            'ref_breach_free' => 'required|in:yes,no,n/a',
            'ref_property_clean' => 'required|in:yes,no,n/a',
            'ref_had_pet' => 'required|in:yes,no,n/a',
            'ref_pet_policy_complied' => 'required|in:yes,no,n/a',
            'ref_cooperative_rating' => 'required|integer|min:1|max:5',
            'ref_property_condition_rating' => 'required|integer|min:1|max:5',
            'ref_overall_rating' => 'required|integer|min:1|max:5',
            'ref_signature_name' => 'required|string|max:255',
            'ref_rent_per_week' => 'nullable|numeric|min:0',
            
            // Comments (optional)
            'ref_is_leaseholder_comment' => 'nullable|string|max:1000',
            'ref_would_rent_again_comment' => 'nullable|string|max:1000',
            'ref_lived_at_address_comment' => 'nullable|string|max:1000',
            'ref_rent_paid_on_time_comment' => 'nullable|string|max:1000',
            'ref_last_inspection_comment' => 'nullable|string|max:1000',
            'ref_rent_per_week_comment' => 'nullable|string|max:1000',
            'ref_full_bond_refund_comment' => 'nullable|string|max:1000',
            'ref_breach_free_comment' => 'nullable|string|max:1000',
            'ref_property_clean_comment' => 'nullable|string|max:1000',
            'ref_had_pet_comment' => 'nullable|string|max:1000',
            'ref_pet_policy_complied_comment' => 'nullable|string|max:1000',
            'ref_cooperative_rating_comment' => 'nullable|string|max:1000',
            'ref_property_condition_rating_comment' => 'nullable|string|max:1000',
            'ref_overall_rating_comment' => 'nullable|string|max:1000',
            
            // Optional fields
            'ref_last_inspection_month' => 'nullable|string',
            'ref_last_inspection_year' => 'nullable|string',
            'ref_tenant_ledger' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], [
            // Custom error messages
            'ref_is_leaseholder.required' => 'Please answer: Is this tenant a leaseholder or an approved occupant?',
            'ref_would_rent_again.required' => 'Please answer: Would you rent to this tenant again?',
            'ref_lived_at_address.required' => 'Please answer: Did the tenant live at the above address?',
            'ref_rent_paid_on_time.required' => 'Please answer: Was the rent always paid on time?',
            'ref_full_bond_refund.required' => 'Please answer: Did they receive a full bond refund?',
            'ref_breach_free.required' => 'Please answer: Was the tenancy free of breach notices?',
            'ref_property_clean.required' => 'Please answer: Was the property found to be clean and well maintained?',
            'ref_had_pet.required' => 'Please answer: Did the tenant have a pet during the tenancy?',
            'ref_pet_policy_complied.required' => 'Please answer: Did the tenant comply with the pet policy?',
            'ref_cooperative_rating.required' => 'Please rate: How co-operative and pleasant was the tenant?',
            'ref_property_condition_rating.required' => 'Please rate: What was the condition of the property when the tenant left?',
            'ref_overall_rating.required' => 'Please rate: Your overall experience with the tenant',
            'ref_signature_name.required' => 'Please enter your full name',
        ]);
        
        // Update address with form data
        $this->updateAddressReference($address, $request, false);
        
        // Mark as submitted
        $address->ref_is_draft = false;
        $address->ref_submitted_at = now();
        $address->reference_verified = true;
        $address->reference_verified_at = now();
        $address->ref_signature_name = $validated['ref_signature_name'];
        $address->ref_signature_date = now();
        $address->save();
        
        // Send thank you email
        try {
            Mail::to($address->reference_email)->send(
                new AddressReferenceThankYou($address)
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send thank you email', [
                'address_id' => $address->id,
                'error' => $e->getMessage()
            ]);
        }
        
        // Redirect to thank you page
        return redirect()->route('address-reference.thank-you', $token);
    }

    /**
     * Thank you page
     */
    public function thankYou($token)
    {
        $address = UserAddress::where('reference_token', $token)->firstOrFail();
        
        return view('address-reference.thank-you', compact('address'));
    }

    /**
     * Helper method to update address reference
     */
    private function updateAddressReference(UserAddress $address, Request $request, bool $isDraft)
    {
        // Save all form fields
        $address->ref_is_leaseholder = $request->input('ref_is_leaseholder');
        $address->ref_is_leaseholder_comment = $request->input('ref_is_leaseholder_comment');
        
        $address->ref_would_rent_again = $request->input('ref_would_rent_again');
        $address->ref_would_rent_again_comment = $request->input('ref_would_rent_again_comment');
        
        $address->ref_lived_at_address = $request->input('ref_lived_at_address');
        $address->ref_lived_at_address_comment = $request->input('ref_lived_at_address_comment');
        
        $address->ref_rent_paid_on_time = $request->input('ref_rent_paid_on_time');
        $address->ref_rent_paid_on_time_comment = $request->input('ref_rent_paid_on_time_comment');
        
        $address->ref_last_inspection_month = $request->input('ref_last_inspection_month');
        $address->ref_last_inspection_year = $request->input('ref_last_inspection_year');
        $address->ref_last_inspection_comment = $request->input('ref_last_inspection_comment');
        
        $address->ref_rent_per_week = $request->input('ref_rent_per_week');
        $address->ref_rent_per_week_comment = $request->input('ref_rent_per_week_comment');
        
        $address->ref_full_bond_refund = $request->input('ref_full_bond_refund');
        $address->ref_full_bond_refund_comment = $request->input('ref_full_bond_refund_comment');

        $address->ref_breach_free = $request->input('ref_breach_free');
        $address->ref_breach_free_comment = $request->input('ref_breach_free_comment');
        
        $address->ref_property_clean = $request->input('ref_property_clean');
        $address->ref_property_clean_comment = $request->input('ref_property_clean_comment');
        
        $address->ref_had_pet = $request->input('ref_had_pet');
        $address->ref_had_pet_comment = $request->input('ref_had_pet_comment');
        
        $address->ref_pet_policy_complied = $request->input('ref_pet_policy_complied');
        $address->ref_pet_policy_complied_comment = $request->input('ref_pet_policy_complied_comment');
        
        $address->ref_cooperative_rating = $request->input('ref_cooperative_rating');
        $address->ref_cooperative_rating_comment = $request->input('ref_cooperative_rating_comment');
        
        $address->ref_property_condition_rating = $request->input('ref_property_condition_rating');
        $address->ref_property_condition_rating_comment = $request->input('ref_property_condition_rating_comment');
        
        $address->ref_overall_rating = $request->input('ref_overall_rating');
        $address->ref_overall_rating_comment = $request->input('ref_overall_rating_comment');
        
        // Handle file upload
        if ($request->hasFile('ref_tenant_ledger')) {
            // Delete old file if exists
            if ($address->ref_tenant_ledger_path) {
                Storage::disk('public')->delete($address->ref_tenant_ledger_path);
            }
            
            $path = $request->file('ref_tenant_ledger')->store('tenant-ledgers', 'public');
            $address->ref_tenant_ledger_path = $path;
        }
        
        // Mark as draft if saving draft
        if ($isDraft) {
            $address->ref_is_draft = true;
            $address->ref_saved_as_draft_at = now();
        }
        
        $address->save();
    }
}