<?php

namespace App\Http\Controllers;

use App\Models\UserReference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReferenceController extends Controller
{
    /**
     * Display the reference form
     */
    public function show($token)
    {
        // Find the reference by hashed token
        $hashedToken = hash('sha256', $token);
        $reference = UserReference::where('reference_token', $hashedToken)->first();

        // Validate reference exists
        if (!$reference) {
            return view('reference.invalid', [
                'message' => 'Invalid reference link. Please check the link in your email and try again.'
            ]);
        }

        // Check if token has expired
        if ($reference->token_expires_at && $reference->token_expires_at->isPast()) {
            $reference->update(['reference_status' => 'expired']);
            return view('reference.invalid', [
                'message' => 'This reference link has expired. Please contact the applicant for a new link.'
            ]);
        }

        // Check if already submitted
        if ($reference->reference_status === 'completed') {
            return view('reference.already-submitted', [
                'reference' => $reference,
                'submittedAt' => $reference->reference_submitted_at
            ]);
        }

        // Load the user data
        $user = $reference->user;

        // Show the form
        return view('reference.form', [
            'reference' => $reference,
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Submit the reference response
     */
    public function submit(Request $request, $token)
    {
        // Find the reference by hashed token
        $hashedToken = hash('sha256', $token);
        $reference = UserReference::where('reference_token', $hashedToken)->first();

        // Validate reference exists and is valid
        if (!$reference || !$reference->isTokenValid()) {
            return redirect()->route('reference.form', $token)
                ->with('error', 'Invalid or expired reference link.');
        }

        // Validate the form data
        $validated = $request->validate([
            'how_long_known' => 'required|string|max:255',
            'relationship_context' => 'required|string|max:1000',
            'character_assessment' => 'required|string|in:excellent,good,fair,poor',
            'reliability_assessment' => 'required|string|in:excellent,good,fair,poor',
            'would_recommend' => 'required|boolean',
            'recommendation_reason' => 'required|string|max:1000',
            'additional_comments' => 'nullable|string|max:2000',
            'referee_name_confirmation' => 'required|string|max:255',
        ], [
            'how_long_known.required' => 'Please specify how long you have known the applicant.',
            'relationship_context.required' => 'Please describe your relationship with the applicant.',
            'character_assessment.required' => 'Please provide a character assessment.',
            'reliability_assessment.required' => 'Please provide a reliability assessment.',
            'would_recommend.required' => 'Please indicate if you would recommend this person as a tenant.',
            'recommendation_reason.required' => 'Please explain your recommendation.',
            'referee_name_confirmation.required' => 'Please confirm your name.',
        ]);

        // Store the response as JSON
        $responseData = [
            'how_long_known' => $validated['how_long_known'],
            'relationship_context' => $validated['relationship_context'],
            'character_assessment' => $validated['character_assessment'],
            'reliability_assessment' => $validated['reliability_assessment'],
            'would_recommend' => (bool) $validated['would_recommend'],
            'recommendation_reason' => $validated['recommendation_reason'],
            'additional_comments' => $validated['additional_comments'] ?? null,
            'referee_name_confirmation' => $validated['referee_name_confirmation'],
            'submitted_ip' => $request->ip(),
            'submitted_user_agent' => $request->userAgent(),
        ];

        // Update the reference
        $reference->update([
            'reference_response' => json_encode($responseData),
            'reference_status' => 'completed',
            'reference_submitted_at' => now(),
        ]);

        Log::info("Reference submitted for user {$reference->user_id} by {$reference->email}");

        // Show thank you page
        return view('reference.thank-you', [
            'reference' => $reference,
            'user' => $reference->user
        ]);
    }
}