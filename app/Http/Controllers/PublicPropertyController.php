<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PublicPropertyController extends Controller
{
    /**
     * Display public property listing page
     */
    public function index(Request $request)
    {
        $query = Property::with(['agency', 'listingAgent', 'featuredImage'])
            ->where('is_published', true)
            ->where('status', 'active');
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('street_name', 'like', "%{$search}%")
                  ->orWhere('suburb', 'like', "%{$search}%")
                  ->orWhere('postcode', 'like', "%{$search}%");
            });
        }
        
        // Filter by listing type
        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }
        
        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }
        
        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }
        
        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        
        // Filter by suburb
        if ($request->filled('suburb')) {
            $query->where('suburb', 'like', "%{$request->suburb}%");
        }
        
        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        $allowedSorts = ['created_at', 'price', 'bedrooms', 'bathrooms'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        }
        
        $properties = $query->paginate(12)->withQueryString();
        
        // Get featured properties
        $featuredProperties = Property::with(['agency', 'listingAgent', 'featuredImage'])
            ->where('is_published', true)
            ->where('is_featured', true)
            ->where('status', 'active')
            ->take(6)
            ->get();
        
        return view('public.properties.index', compact('properties', 'featuredProperties'));
    }
    
    /**
     * Display a single property page (public view)
     * Using property_code instead of ID for SEO-friendly URLs
     */
    public function show($code)
    {
        // Find property by property_code
        $property = Property::with([
            'agency', 
            'listingAgent', 
            'images' => function($query) {
                $query->orderBy('sort_order')->orderBy('id');
            }
        ])
        ->where('property_code', $code)
        ->where('is_published', true)
        ->firstOrFail();
        
        // Separate regular images from floorplans
        $regularImages = $property->images->filter(function($image) {
            return !str_contains(strtolower($image->title ?? ''), 'floorplan') &&
                   !str_contains(strtolower($image->caption ?? ''), 'floorplan');
        });
        
        $floorplans = $property->images->filter(function($image) {
            return str_contains(strtolower($image->title ?? ''), 'floorplan') ||
                   str_contains(strtolower($image->caption ?? ''), 'floorplan');
        });
        
        // Increment view count
        $property->incrementViews();
        
        // Get similar properties
        $similarProperties = Property::with(['agency', 'featuredImage'])
            ->where('is_published', true)
            ->where('status', 'active')
            ->where('id', '!=', $property->id)
            ->where('suburb', $property->suburb)
            ->where('listing_type', $property->listing_type)
            ->inRandomOrder()
            ->limit(3)
            ->get();
        
        // Check if user saved this property (if logged in)
        $isSaved = false;
        if (Auth::check() && Auth::user()->hasRole('user')) {
            $isSaved = Auth::user()->hasSavedProperty($property->id);
        }
        
        return view('public.properties.show', compact('property', 'regularImages', 'floorplans', 'similarProperties', 'isSaved'));
    }
    
    /**
     * Submit an enquiry about a property
     * Requires authentication
     */
    public function submitEnquiry(Request $request, $code)
    {
        // Require authentication
        if (!Auth::check()) {
            return back()->with('error', 'Please login to send an enquiry.');
        }
        
        $user = Auth::user();
        
        // Find property
        $property = Property::where('property_code', $code)
            ->where('is_published', true)
            ->firstOrFail();
        
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Create enquiry
            PropertyEnquiry::create([
                'user_id' => $user->id,
                'property_id' => $property->id,
                'agency_id' => $property->agency_id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'message' => $validated['message'],
                'status' => 'new',
            ]);
            
            // Increment enquiry count
            $property->incrementEnquiries();
            
            DB::commit();
            
            // Log the enquiry
            Log::info('New property enquiry', [
                'property_id' => $property->id,
                'property_code' => $property->property_code,
                'user_id' => $user->id,
            ]);
            
            // TODO: Send email notification to listing agent
            
            return back()->with('success', 'Your enquiry has been sent! The agent will contact you soon.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Property enquiry submission failed', [
                'property_code' => $code,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Failed to send enquiry. Please try again.');
        }
    }
}