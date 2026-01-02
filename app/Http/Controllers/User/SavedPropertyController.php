<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SavedProperty;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedPropertyController extends Controller
{
    /**
     * Toggle save/unsave property
     */
    public function toggle(Property $property)
    {
        $user = Auth::user();

        // Check if property is already saved
        $saved = SavedProperty::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->first();

        if ($saved) {
            // Unsave the property
            $saved->delete();
            
            return response()->json([
                'success' => true,
                'favorited' => false,
                'message' => 'Property removed from saved list'
            ]);
        } else {
            // Save the property
            SavedProperty::create([
                'user_id' => $user->id,
                'property_id' => $property->id,
            ]);
            
            return response()->json([
                'success' => true,
                'favorited' => true,
                'message' => 'Property saved successfully'
            ]);
        }
    }

    /**
     * Get all saved properties for the authenticated user
     */
    public function index()
    {
        $savedProperties = Auth::user()->savedProperties()
            ->with('property.agency')
            ->latest()
            ->paginate(12);

        return view('user.saved-properties.index', compact('savedProperties'));
    }

    /**
     * Remove a saved property
     */
    public function destroy(SavedProperty $savedProperty)
    {
        // Make sure the saved property belongs to the authenticated user
        if ($savedProperty->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $savedProperty->delete();

        return redirect()->back()->with('success', 'Property removed from saved list');
    }
}