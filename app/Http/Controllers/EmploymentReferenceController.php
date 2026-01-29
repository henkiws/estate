<?php

namespace App\Http\Controllers;

use App\Models\UserEmployment;
use App\Models\UserEmploymentReference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmploymentReferenceController extends Controller
{
    /**
     * Show the employment reference form
     */
    public function showForm($token)
    {
        $employment = UserEmployment::where('reference_token', $token)->firstOrFail();
        
        // Check if already verified
        if ($employment->reference_status === 'verified') {
            return view('employment-reference.already-submitted', compact('employment'));
        }
        
        // Check if token is expired (more than 30 days old)
        if ($employment->reference_email_sent_at && $employment->reference_email_sent_at->lt(now()->subDays(30))) {
            return view('employment-reference.expired', compact('employment'));
        }
        
        $user = $employment->user;
        
        return view('employment-reference.form', compact('employment', 'user'));
    }

    /**
     * Submit the employment reference
     */
    public function submitReference(Request $request, $token)
    {
        $employment = UserEmployment::where('reference_token', $token)->firstOrFail();
        
        // Check if already verified
        if ($employment->reference_status === 'verified') {
            return redirect()->route('employment.reference.form', $token)
                ->with('error', 'This reference has already been submitted.');
        }
        
        $validated = $request->validate([
            'currently_works_there' => 'required|boolean',
            'current_works_there_comment' => 'nullable|string|max:500',
            'job_title_correct' => 'required|boolean',
            'job_title_comment' => 'nullable|string|max:500',
            'employment_type' => 'required|string|in:full_time,part_time,casual,contract,other',
            'employment_type_comment' => 'nullable|string|max:500',
            'actual_start_date' => 'nullable|date',
            'start_date_comment' => 'nullable|string|max:500',
            'annual_income' => 'required|numeric|min:0|max:9999999.99',
            'annual_income_comment' => 'nullable|string|max:500',
            'role_ongoing' => 'required|boolean',
            'role_ongoing_comment' => 'nullable|string|max:500',
            'referee_name' => 'required|string|max:255',
            'referee_email' => 'required|email|max:255',
            'referee_position' => 'required|string|max:255',
            'additional_comments' => 'nullable|string|max:1000',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Create or update reference
            $reference = UserEmploymentReference::updateOrCreate(
                ['user_employment_id' => $employment->id],
                array_merge($validated, [
                    'submitted_at' => now(),
                    'submitted_ip' => $request->ip(),
                ])
            );
            
            // Update employment status
            $employment->reference_status = 'verified';
            $employment->reference_verified_at = now();
            $employment->save();
            
            DB::commit();
            
            return view('employment-reference.success', compact('employment'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Employment reference submission error', [
                'employment_id' => $employment->id,
                'error' => $e->getMessage(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while submitting the reference. Please try again.');
        }
    }

    /**
     * Opt out of providing reference
     */
    public function optOut($token)
    {
        $employment = UserEmployment::where('reference_token', $token)->firstOrFail();
        
        return view('employment-reference.optout', compact('employment'));
    }

    /**
     * Confirm opt out
     */
    public function confirmOptOut(Request $request, $token)
    {
        $employment = UserEmployment::where('reference_token', $token)->firstOrFail();
        
        // Mark as opted out (you can add a field for this if needed)
        // For now, we'll just show a confirmation message
        
        return view('employment-reference.optout-confirmed', compact('employment'));
    }
}