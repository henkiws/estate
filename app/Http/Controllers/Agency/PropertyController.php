<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Agent;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    /**
     * Display listing of properties
     */
    public function index(Request $request)
    {
        $agency = Auth::user()->agency;
        
        $query = Property::with(['listingAgent', 'propertyManager', 'featuredImage'])
            ->where('agency_id', $agency->id);
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('street_name', 'like', "%{$search}%")
                  ->orWhere('suburb', 'like', "%{$search}%")
                  ->orWhere('property_code', 'like', "%{$search}%")
                  ->orWhere('postcode', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by listing type
        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }
        
        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }
        
        // Filter by agent
        if ($request->filled('agent_id')) {
            $query->where('listing_agent_id', $request->agent_id);
        }
        
        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $properties = $query->paginate(12)->withQueryString();
        
        // Stats
        $stats = [
            'total' => Property::where('agency_id', $agency->id)->count(),
            'active' => Property::where('agency_id', $agency->id)->where('status', 'active')->count(),
            'sold' => Property::where('agency_id', $agency->id)->where('status', 'sold')->count(),
            'leased' => Property::where('agency_id', $agency->id)->where('status', 'leased')->count(),
            'for_sale' => Property::where('agency_id', $agency->id)->where('listing_type', 'sale')->whereIn('status', ['active', 'under_contract'])->count(),
            'for_rent' => Property::where('agency_id', $agency->id)->where('listing_type', 'rent')->whereIn('status', ['active', 'under_contract'])->count(),
        ];
        
        // Get agents for filter
        $agents = Agent::where('agency_id', $agency->id)
            ->where('status', 'active')
            ->orderBy('first_name')
            ->get();
        
        return view('agency.properties.index', compact('properties', 'stats', 'agents', 'agency'));
    }

    /**
     * Show create property form
     */
    public function create()
    {
        $agency = Auth::user()->agency;
        
        // Get active agents
        $agents = Agent::where('agency_id', $agency->id)
            ->where('status', 'active')
            ->orderBy('first_name')
            ->get();
        
        return view('agency.properties.create', compact('agency', 'agents'));
    }

    /**
     * Store new property
     */
    public function store(Request $request)
    {
        $agency = Auth::user()->agency;
        
        $validated = $request->validate([
            'property_type' => 'required|in:house,apartment,unit,townhouse,villa,land,studio,duplex,farm,acreage,retirement,block_of_units,commercial,industrial',
            'listing_type' => 'required|in:sale,rent,lease',
            'street_number' => 'nullable|string|max:20',
            'street_name' => 'required|string|max:255',
            'street_type' => 'nullable|string|max:50',
            'unit_number' => 'nullable|string|max:20',
            'suburb' => 'required|string|max:100',
            'state' => 'required|string|max:10',
            'postcode' => 'required|string|max:10',
            'bedrooms' => 'nullable|integer|min:0|max:20',
            'bathrooms' => 'nullable|integer|min:0|max:20',
            'parking_spaces' => 'nullable|integer|min:0|max:20',
            'garages' => 'nullable|integer|min:0|max:20',
            'land_area' => 'nullable|numeric|min:0',
            'floor_area' => 'nullable|numeric|min:0',
            'year_built' => 'nullable|integer|min:1800|max:' . (date('Y') + 2),
            'price' => 'nullable|numeric|min:0',
            'price_display' => 'boolean',
            'price_text' => 'nullable|string|max:100',
            'rent_per_week' => 'nullable|numeric|min:0',
            'bond_amount' => 'nullable|numeric|min:0',
            'available_from' => 'nullable|date',
            'headline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'listing_agent_id' => 'nullable|exists:agents,id',
            'property_manager_id' => 'nullable|exists:agents,id',
            'is_featured' => 'boolean',
        ]);
        
        DB::beginTransaction();
        
        try {
            $property = Property::create(array_merge($validated, [
                'agency_id' => $agency->id,
                'status' => 'draft',
            ]));
            
            DB::commit();
            
            return redirect()
                ->route('agency.properties.show', $property->id)
                ->with('success', 'Property added successfully!');
                    
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to add property. Please try again.');
        }
    }

    /**
     * Show property details
     */
    public function show(Property $property)
    {
        $agency = Auth::user()->agency;
        
        if ($property->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to property.');
        }
        
        $property->load(['listingAgent', 'propertyManager', 'images']);
        
        // Get recent activities
        $activities = ActivityLog::where('subject_type', Property::class)
            ->where('subject_id', $property->id)
            ->latest()
            ->take(10)
            ->get();
        
        return view('agency.properties.show', compact('property', 'activities', 'agency'));
    }

    /**
     * Show edit form
     */
    public function edit(Property $property)
    {
        $agency = Auth::user()->agency;
        
        if ($property->agency_id !== $agency->id) {
            abort(403);
        }
        
        $agents = Agent::where('agency_id', $agency->id)
            ->where('status', 'active')
            ->orderBy('first_name')
            ->get();
        
        return view('agency.properties.edit', compact('property', 'agents', 'agency'));
    }

    /**
     * Update property
     */
    public function update(Request $request, Property $property)
    {
        $agency = Auth::user()->agency;
        
        if ($property->agency_id !== $agency->id) {
            abort(403);
        }
        
        $validated = $request->validate([
            'property_type' => 'required|in:house,apartment,unit,townhouse,villa,land,studio,duplex,farm,acreage,retirement,block_of_units,commercial,industrial',
            'listing_type' => 'required|in:sale,rent,lease',
            'street_number' => 'nullable|string|max:20',
            'street_name' => 'required|string|max:255',
            'street_type' => 'nullable|string|max:50',
            'unit_number' => 'nullable|string|max:20',
            'suburb' => 'required|string|max:100',
            'state' => 'required|string|max:10',
            'postcode' => 'required|string|max:10',
            'bedrooms' => 'nullable|integer|min:0|max:20',
            'bathrooms' => 'nullable|integer|min:0|max:20',
            'parking_spaces' => 'nullable|integer|min:0|max:20',
            'garages' => 'nullable|integer|min:0|max:20',
            'land_area' => 'nullable|numeric|min:0',
            'floor_area' => 'nullable|numeric|min:0',
            'year_built' => 'nullable|integer|min:1800|max:' . (date('Y') + 2),
            'price' => 'nullable|numeric|min:0',
            'price_display' => 'boolean',
            'price_text' => 'nullable|string|max:100',
            'rent_per_week' => 'nullable|numeric|min:0',
            'bond_amount' => 'nullable|numeric|min:0',
            'available_from' => 'nullable|date',
            'headline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'listing_agent_id' => 'nullable|exists:agents,id',
            'property_manager_id' => 'nullable|exists:agents,id',
            'status' => 'required|in:draft,active,under_contract,sold,leased,withdrawn,off_market,expired',
            'is_featured' => 'boolean',
        ]);
        
        try {
            $property->update($validated);
            
            return redirect()
                ->route('agency.properties.show', $property->id)
                ->with('success', 'Property updated successfully!');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update property. Please try again.');
        }
    }

    /**
     * Delete property
     */
    public function destroy(Property $property)
    {
        $agency = Auth::user()->agency;
        
        if ($property->agency_id !== $agency->id) {
            abort(403);
        }
        
        try {
            // Delete all images
            foreach ($property->images as $image) {
                Storage::disk('public')->delete($image->file_path);
                $image->delete();
            }
            
            $address = $property->full_address;
            $property->delete();
            
            return redirect()
                ->route('agency.properties.index')
                ->with('success', "Property {$address} has been deleted.");
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete property. Please try again.');
        }
    }

    /**
     * Publish property
     */
    public function publish(Property $property)
    {
        $agency = Auth::user()->agency;
        
        if ($property->agency_id !== $agency->id) {
            abort(403);
        }
        
        $property->publish();
        
        return back()->with('success', 'Property published successfully!');
    }

    /**
     * Unpublish property
     */
    public function unpublish(Property $property)
    {
        $agency = Auth::user()->agency;
        
        if ($property->agency_id !== $agency->id) {
            abort(403);
        }
        
        $property->unpublish();
        
        return back()->with('success', 'Property unpublished.');
    }

    /**
     * Mark as sold
     */
    public function markAsSold(Request $request, Property $property)
    {
        $agency = Auth::user()->agency;
        
        if ($property->agency_id !== $agency->id) {
            abort(403);
        }
        
        $request->validate([
            'sale_price' => 'nullable|numeric|min:0',
            'sale_date' => 'nullable|date',
        ]);
        
        $property->markAsSold($request->sale_price, $request->sale_date);
        
        return back()->with('success', 'Property marked as sold!');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Property $property)
    {
        $agency = Auth::user()->agency;
        
        if ($property->agency_id !== $agency->id) {
            abort(403);
        }
        
        $property->update(['is_featured' => !$property->is_featured]);
        
        return back()->with('success', 'Featured status updated.');
    }

    /**
     * Upload property images
     */
    public function uploadImages(Request $request, Property $property)
    {
        $agency = Auth::user()->agency;
        
        if ($property->agency_id !== $agency->id) {
            abort(403);
        }
        
        $request->validate([
            'images' => 'required|array|max:20',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB
        ]);
        
        $uploadedCount = 0;
        
        foreach ($request->file('images') as $file) {
            $path = $file->store('properties/' . $property->id, 'public');
            
            // Get image dimensions
            $dimensions = getimagesize($file->getRealPath());
            
            PropertyImage::create([
                'property_id' => $property->id,
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'width' => $dimensions[0] ?? null,
                'height' => $dimensions[1] ?? null,
                'sort_order' => $property->images()->count(),
                'is_featured' => $property->images()->count() === 0, // First image is featured
            ]);
            
            $uploadedCount++;
        }
        
        return back()->with('success', "{$uploadedCount} images uploaded successfully!");
    }

    /**
     * Delete property image
     */
    public function deleteImage(Property $property, PropertyImage $image)
    {
        $agency = Auth::user()->agency;
        
        if ($property->agency_id !== $agency->id || $image->property_id !== $property->id) {
            abort(403);
        }
        
        Storage::disk('public')->delete($image->file_path);
        $image->delete();
        
        return back()->with('success', 'Image deleted successfully.');
    }

    /**
     * Set featured image
     */
    public function setFeaturedImage(Property $property, PropertyImage $image)
    {
        $agency = Auth::user()->agency;
        
        if ($property->agency_id !== $agency->id || $image->property_id !== $property->id) {
            abort(403);
        }
        
        // Remove featured from all images
        PropertyImage::where('property_id', $property->id)->update(['is_featured' => false]);
        
        // Set this image as featured
        $image->update(['is_featured' => true]);
        
        return back()->with('success', 'Featured image updated.');
    }
}