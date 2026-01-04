<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SavedProperty;
use App\Models\Property;
use App\Models\Application;
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
    public function index(Request $request)
    {
        $query = SavedProperty::with(['property.images', 'property.agency'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('property', function($q) use ($search) {
                $q->where('address', 'like', "%{$search}%")
                  ->orWhere('suburb', 'like', "%{$search}%")
                  ->orWhere('property_code', 'like', "%{$search}%");
            });
        }
        
        // Property type filter
        if ($request->filled('property_type')) {
            $query->whereHas('property', function($q) use ($request) {
                $q->where('property_type', $request->property_type);
            });
        }
        
        // Sort
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_low':
                $query->join('properties', 'saved_properties.property_id', '=', 'properties.id')
                      ->orderBy('properties.price_per_week', 'asc')
                      ->select('saved_properties.*');
                break;
            case 'price_high':
                $query->join('properties', 'saved_properties.property_id', '=', 'properties.id')
                      ->orderBy('properties.price_per_week', 'desc')
                      ->select('saved_properties.*');
                break;
            default: // recent
                $query->orderBy('created_at', 'desc');
        }
        
        $viewMode = $request->get('view', 'grid');
        $savedProperties = $query->paginate(12)->appends($request->except('page'));
        
        // Get properties user has applied to
        $appliedPropertyIds = Application::where('user_id', Auth::id())
                                        ->pluck('property_id')
                                        ->toArray();
        
        // Get total count
        $totalCount = SavedProperty::where('user_id', Auth::id())->count();
        
        return view('user.saved-properties.index', compact(
            'savedProperties',
            'viewMode',
            'appliedPropertyIds',
            'totalCount'
        ));
    }

    /**
     * Remove a saved property
    */
    public function destroy(Property $property)
    {
        $saved = SavedProperty::where('user_id', Auth::id())
                             ->where('property_id', $property->id)
                             ->first();
        
        if ($saved) {
            $saved->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Property removed from saved list'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Property not found in saved list'
        ], 404);
    }
}