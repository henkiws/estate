<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        // Find property by code or slug
        $property = Property::query()
            ->with(['agency', 'listingAgent', 'images'])
            ->where(function($query) use ($code) {
                $query->where('property_code', $code)
                      ->orWhere('slug', $code);
            })
            ->where('is_published', true)
            ->firstOrFail();
        
        // Eager load propertyManager only if property_manager_id exists
        if ($property->property_manager_id) {
            $property->load('propertyManager');
        }
        
        // Increment view count
        $property->incrementViews();
        
        // Get similar properties (same suburb, same listing type)
        $similarProperties = Property::with(['agency', 'listingAgent', 'featuredImage'])
            ->where('id', '!=', $property->id)
            ->where('agency_id', $property->agency_id)
            ->where('listing_type', $property->listing_type)
            ->where('suburb', $property->suburb)
            ->where('is_published', true)
            ->where('status', 'active')
            ->take(3)
            ->get();
        
        // If not enough similar properties, get more from same agency
        if ($similarProperties->count() < 3) {
            $additionalProperties = Property::with(['agency', 'listingAgent', 'featuredImage'])
                ->where('id', '!=', $property->id)
                ->where('agency_id', $property->agency_id)
                ->where('listing_type', $property->listing_type)
                ->where('is_published', true)
                ->where('status', 'active')
                ->whereNotIn('id', $similarProperties->pluck('id'))
                ->take(3 - $similarProperties->count())
                ->get();
            
            $similarProperties = $similarProperties->merge($additionalProperties);
        }
        
        return view('public.properties.show', compact('property', 'similarProperties'));
    }
    
    /**
     * Submit a property application (for rental properties)
     */
    public function submitApplication(Request $request, $code)
    {
        // Find property
        $property = Property::where('property_code', $code)
            ->orWhere('slug', $code)
            ->where('is_published', true)
            ->where('listing_type', 'rent')
            ->firstOrFail();
        
        // Validate request
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'move_in_date' => 'required|date|after:today',
            'current_address' => 'required|string|max:255',
            'employment_status' => 'required|string|in:employed,self_employed,student,retired,unemployed',
            'employer_name' => 'nullable|string|max:255',
            'annual_income' => 'required|numeric|min:0',
            'number_of_occupants' => 'required|integer|min:1|max:20',
            'has_pets' => 'required|boolean',
            'pet_details' => 'nullable|string|max:500',
            'references' => 'nullable|array|max:3',
            'references.*.name' => 'required|string|max:100',
            'references.*.relationship' => 'required|string|max:100',
            'references.*.phone' => 'required|string|max:20',
            'additional_information' => 'nullable|string|max:1000',
        ]);
        
        try {
            // Create application
            $application = PropertyApplication::create([
                'property_id' => $property->id,
                'agency_id' => $property->agency_id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'move_in_date' => $validated['move_in_date'],
                'current_address' => $validated['current_address'],
                'employment_status' => $validated['employment_status'],
                'employer_name' => $validated['employer_name'] ?? null,
                'annual_income' => $validated['annual_income'],
                'number_of_occupants' => $validated['number_of_occupants'],
                'has_pets' => $validated['has_pets'],
                'pet_details' => $validated['pet_details'] ?? null,
                'references' => $validated['references'] ?? [],
                'additional_information' => $validated['additional_information'] ?? null,
                'status' => 'pending',
            ]);
            
            // Increment enquiry count
            $property->incrementEnquiries();
            
            // Log activity
            Log::info('New property application submitted', [
                'property_id' => $property->id,
                'property_code' => $property->property_code,
                'applicant_email' => $validated['email'],
            ]);
            
            // TODO: Send email notification to agency
            
            return redirect()
                ->route('property.show', $code)
                ->with('success', 'Your application has been submitted successfully! The agency will contact you soon.');
                
        } catch (\Exception $e) {
            Log::error('Property application submission failed', [
                'property_code' => $code,
                'error' => $e->getMessage(),
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Failed to submit application. Please try again.');
        }
    }
    
    /**
     * Submit an enquiry about a property
     */
    public function submitEnquiry(Request $request, $code)
    {
        // Find property
        $property = Property::where('property_code', $code)
            ->orWhere('slug', $code)
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
            // TODO: Create PropertyEnquiry model and store enquiry
            // For now, just increment the counter
            $property->incrementEnquiries();
            
            // Log the enquiry
            Log::info('New property enquiry', [
                'property_id' => $property->id,
                'property_code' => $property->property_code,
                'enquirer_email' => $validated['email'],
            ]);
            
            // TODO: Send email notification to listing agent
            
            return back()->with('success', 'Your enquiry has been sent! The agent will contact you soon.');
            
        } catch (\Exception $e) {
            Log::error('Property enquiry submission failed', [
                'property_code' => $code,
                'error' => $e->getMessage(),
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Failed to send enquiry. Please try again.');
        }
    }
    
    /**
     * Book an inspection
     */
    public function bookInspection(Request $request, $code)
    {
        // Find property
        $property = Property::where('property_code', $code)
            ->orWhere('slug', $code)
            ->where('is_published', true)
            ->firstOrFail();
        
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'inspection_time' => 'required|string|max:100',
            'number_of_people' => 'required|integer|min:1|max:10',
        ]);
        
        try {
            // TODO: Create PropertyInspection model and store booking
            // For now, just increment the counter
            $property->incrementInspections();
            
            // Log the booking
            Log::info('New inspection booking', [
                'property_id' => $property->id,
                'property_code' => $property->property_code,
                'visitor_email' => $validated['email'],
            ]);
            
            // TODO: Send confirmation email to visitor
            // TODO: Send notification to listing agent
            
            return back()->with('success', 'Inspection booked successfully! You will receive a confirmation email.');
            
        } catch (\Exception $e) {
            Log::error('Inspection booking failed', [
                'property_code' => $code,
                'error' => $e->getMessage(),
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Failed to book inspection. Please try again.');
        }
    }
}