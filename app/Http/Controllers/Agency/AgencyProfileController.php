<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AgencyProfileController extends Controller
{
    /**
     * Show the agency profile edit form
     */
    public function edit()
    {
        $agency = Auth::user()->agency;
        
        return view('agency.profile.edit', compact('agency'));
    }

    /**
     * Update the agency profile
     */
    public function update(Request $request)
    {
        $agency = Auth::user()->agency;

        $validated = $request->validate([
            // Company Information
            // 'agency_name' => 'required|string|max:255',
            'trading_name' => 'nullable|string|max:255',
            // 'abn' => [
            //     'required',
            //     'string',
            //     'size:11',
            //     'regex:/^[0-9]{11}$/',
            //     Rule::unique('agencies')->ignore($agency->id)
            // ],
            // 'acn' => [
            //     'nullable',
            //     'string',
            //     'size:9',
            //     'regex:/^[0-9]{9}$/',
            //     Rule::unique('agencies')->ignore($agency->id)
            // ],
            'business_type' => 'required|in:sole_trader,partnership,company,trust',
            // 'description' => 'nullable|string|max:1000',
            
            // License Information
            'license_number' => 'required|string|max:50',
            'license_holder_name' => 'required|string|max:255',
            'license_expiry_date' => 'required|date|after:today',
            
            // Contact Information
            'business_address' => 'required|string|max:500',
            'state' => 'required|string|max:50',
            'postcode' => 'required|string|max:10',
            'business_phone' => 'required|string|max:20',
            'business_email' => 'required|email|max:255',
            'website_url' => 'nullable|url|max:255',
            
            // Social Media (all optional)
            // 'facebook_url' => 'nullable|url|max:255',
            // 'linkedin_url' => 'nullable|url|max:255',
            // 'instagram_url' => 'nullable|url|max:255',
            // 'twitter_url' => 'nullable|url|max:255',
            
            // Logo Upload
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB max
        ], [
            'abn.required' => 'ABN is required',
            'abn.size' => 'ABN must be exactly 11 digits',
            'abn.regex' => 'ABN must contain only numbers',
            'abn.unique' => 'This ABN is already registered',
            'acn.size' => 'ACN must be exactly 9 digits',
            'acn.regex' => 'ACN must contain only numbers',
            'acn.unique' => 'This ACN is already registered',
            'license_expiry_date.after' => 'License expiry date must be in the future',
            'logo.max' => 'Logo file size must not exceed 2MB',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($agency->logo_path) {
                Storage::disk('public')->delete($agency->logo_path);
            }
            
            // Store new logo
            $path = $request->file('logo')->store('agencies/logos', 'public');
            $validated['logo_path'] = $path;
        }

        // Update agency
        $agency->update($validated);

        return redirect()
            ->route('agency.profile.edit')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete agency logo
     */
    public function deleteLogo()
    {
        $agency = Auth::user()->agency;

        if ($agency->logo_path) {
            Storage::disk('public')->delete($agency->logo_path);
            $agency->update(['logo_path' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logo deleted successfully'
        ]);
    }
}