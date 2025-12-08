<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedPropertyController extends Controller
{
    /**
     * Display user's saved properties
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->savedProperties()
            ->with(['agency', 'listingAgent', 'featuredImage'])
            ->where('is_published', true);
        
        // Filter by listing type
        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }
        
        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }
        
        // Sort
        $sortField = $request->get('sort', 'saved_properties.created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $savedProperties = $query->paginate(12);
        
        return view('user.saved-properties', compact('savedProperties'));
    }
    
    /**
     * Toggle save/unsave property
     */
    public function toggle($code)
    {
        $user = Auth::user();
        
        // Find property by code
        $property = Property::where('property_code', $code)
            ->where('is_published', true)
            ->firstOrFail();
        
        // Toggle save
        $saved = $user->toggleSaveProperty($property->id);
        
        if (request()->wantsJson()) {
            return response()->json([
                'saved' => $saved,
                'message' => $saved ? 'Property saved!' : 'Property removed from saved.',
            ]);
        }
        
        return back()->with('success', $saved ? 'Property saved!' : 'Property removed from saved.');
    }
    
    /**
     * Remove property from saved (alternative route)
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $user->savedProperties()->detach($id);
        
        return back()->with('success', 'Property removed from saved.');
    }
}