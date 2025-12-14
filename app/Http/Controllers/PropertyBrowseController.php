<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyBrowseController extends Controller
{
    /**
     * Display property browse/search page
     */
    public function index(Request $request)
    {
        $query = Property::with(['images', 'agency'])
            ->where('status', 'available');
        
        // Search by address/suburb
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('address', 'like', "%{$search}%")
                  ->orWhere('suburb', 'like', "%{$search}%")
                  ->orWhere('property_code', 'like', "%{$search}%");
            });
        }
        
        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            if ($request->bedrooms === '5+') {
                $query->where('bedrooms', '>=', 5);
            } else {
                $query->where('bedrooms', $request->bedrooms);
            }
        }
        
        // Filter by bathrooms
        if ($request->filled('bathrooms')) {
            if ($request->bathrooms === '3+') {
                $query->where('bathrooms', '>=', 3);
            } else {
                $query->where('bathrooms', $request->bathrooms);
            }
        }
        
        // Filter by parking
        if ($request->filled('parking')) {
            if ($request->parking === '2+') {
                $query->where('parking_spaces', '>=', 2);
            } else {
                $query->where('parking_spaces', $request->parking);
            }
        }
        
        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }
        
        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price_per_week', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price_per_week', '<=', $request->price_max);
        }
        
        // Filter by pet friendly
        if ($request->filled('pet_friendly') && $request->pet_friendly) {
            $query->where('pet_friendly', true);
        }
        
        // Filter by furnished
        if ($request->filled('furnished') && $request->furnished) {
            $query->where('furnished', true);
        }
        
        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price_per_week', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_per_week', 'desc');
                break;
            case 'bedrooms_high':
                $query->orderBy('bedrooms', 'desc');
                break;
            case 'bedrooms_low':
                $query->orderBy('bedrooms', 'asc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
        }
        
        $viewMode = $request->get('view', 'grid'); // grid, list, or map
        $properties = $query->paginate(12)->appends($request->except('page'));
        
        // Get user's favorites if logged in
        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favorite::forUser(Auth::id())
                                  ->pluck('property_id')
                                  ->toArray();
        }
        
        // Get filter counts for display
        $totalCount = Property::where('status', 'available')->count();
        
        return view('properties.index', compact(
            'properties',
            'viewMode',
            'favoriteIds',
            'totalCount'
        ));
    }

    /**
     * Display property detail page
     */
    public function show(Property $property)
    {
        $property->load(['images', 'agency', 'features']);
        
        // Check if favorited (if logged in)
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Favorite::isFavorited(Auth::id(), $property->id);
        }
        
        // Get similar properties
        $similarProperties = Property::with(['images'])
            ->where('suburb', $property->suburb)
            ->where('id', '!=', $property->id)
            ->where('status', 'available')
            ->whereBetween('price_per_week', [
                $property->price_per_week * 0.8,
                $property->price_per_week * 1.2
            ])
            ->take(3)
            ->get();
        
        // Increment views (optional)
        // $property->increment('views');
        
        return view('properties.show', compact(
            'property',
            'isFavorited',
            'similarProperties'
        ));
    }
}