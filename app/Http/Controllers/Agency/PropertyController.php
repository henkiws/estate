<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties.
     */
    public function index(Request $request)
    {
        $agency = Auth::user()->agency;
        
        $query = Property::where('agency_id', $agency->id)
            ->with(['agents', 'images', 'applications']);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('property_code', 'like', "%{$search}%")
                  ->orWhere('street_name', 'like', "%{$search}%")
                  ->orWhere('suburb', 'like', "%{$search}%")
                  ->orWhere('full_address', 'like', "%{$search}%");
            });
        }

        $properties = $query->latest()->paginate(12);
        
        // Statistics
        $stats = [
            'total' => Property::where('agency_id', $agency->id)->count(),
            'active' => Property::where('agency_id', $agency->id)->where('status', 'active')->count(),
            'for_rent' => Property::where('agency_id', $agency->id)->where('listing_type', 'rent')->count(),
            'for_sale' => Property::where('agency_id', $agency->id)->where('listing_type', 'sale')->count(),
        ];

        return view('agency.properties.index', compact('properties', 'stats'));
    }

    /**
     * Show the form for creating a new property.
     */
    public function create()
    {
        $agency = Auth::user()->agency;
        $agents = Agent::where('agency_id', $agency->id)
                      ->where('status', 'active')
                      ->get();

        return view('agency.properties.create', compact('agents'));
    }

   /**
     * Store a newly created property.
     */
    public function store(Request $request)
    {
        $agency = Auth::user()->agency;

        $validated = $request->validate([
            // Property Type
            'property_type' => 'required|string',
            'listing_type' => 'required|in:sale,rent',
            
            // Address
            'street_number' => 'nullable|string|max:20',
            'street_name' => 'required|string|max:255',
            'unit_number' => 'nullable|string|max:20',
            'suburb' => 'required|string|max:100',
            'state' => 'required|string|max:50',
            'postcode' => 'required|string|max:10',
            
            // Details
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'parking_spaces' => 'nullable|integer|min:0',
            'land_size' => 'nullable|numeric|min:0',
            'unit_size' => 'nullable|numeric|min:0', // Changed from building_size
            
            // Pricing
            'price' => 'nullable|numeric|min:0',
            'rent_per_week' => 'nullable|numeric|min:0',
            'bond_weeks' => 'nullable|integer|min:1|max:52',
            'price_text' => 'nullable|string|max:255',
            
            // Availability
            'available_from' => 'nullable|date',
            'status' => 'required|in:draft,active',

            'condition' => 'required|string',
            'storage' => 'required|string',
            
            // Files
            'floorplan' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            
            // Agents
            'agents' => 'nullable|array',
            'agents.*' => 'exists:agents,id',
        ]);

        // Build full address (without street_type)
        $addressParts = array_filter([
            $validated['unit_number'] ?? null,
            $validated['street_number'] ?? null,
            $validated['street_name'],
            $validated['suburb'],
            $validated['state'],
            $validated['postcode'],
        ]);
        $validated['full_address'] = implode(' ', $addressParts);

        // Set bond weeks default
        if ($validated['listing_type'] === 'rent' && empty($validated['bond_weeks'])) {
            $validated['bond_weeks'] = 4;
        }

        // Map unit_size to building_size for database compatibility
        if (isset($validated['unit_size'])) {
            $validated['building_size'] = $validated['unit_size'];
            unset($validated['unit_size']);
        }

        // Create property
        $property = new Property($validated);
        $property->agency_id = $agency->id;
        $property->save();

        // Handle floorplan upload
        if ($request->hasFile('floorplan')) {
            $path = $request->file('floorplan')->store('properties/floorplans', 'public');
            $property->update(['floorplan_path' => $path]);
        }

        // Assign agents
        if (!empty($validated['agents'])) {
            foreach ($validated['agents'] as $index => $agentId) {
                $property->agents()->attach($agentId, [
                    'role' => $index === 0 ? 'listing_agent' : 'co_agent',
                    'sort_order' => $index,
                ]);
            }
        }

        // Return success with property URL
        return response()->json([
            'success' => true,
            'message' => 'Property added successfully!',
            'property_id' => $property->id,
            'public_url' => route('properties.show', $property->public_url_code),
            'edit_url' => route('agency.properties.edit', $property->id),
            'public_url_code' => $property->public_url_code,
        ]);
    }

    /**
     * Display the specified property.
     */
    public function show(Property $property)
    {
        // $this->authorize('view', $property);
        
        $property->load(['agency', 'agents', 'images', 'applications']);
        
        return view('agency.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the property.
     */
    public function edit(Property $property)
    {
        // $this->authorize('update', $property);
        
        $agency = Auth::user()->agency;
        $agents = Agent::where('agency_id', $agency->id)
                      ->where('status', 'active')
                      ->get();
        
        $property->load(['agents', 'images']);
        
        return view('agency.properties.edit', compact('property', 'agents'));
    }

    /**
     * Update the specified property.
     */
    public function update(Request $request, Property $property)
    {
        // $this->authorize('update', $property);

        $validated = $request->validate([
            // Property Type
            'property_type' => 'required|string',
            'listing_type' => 'required|in:sale,rent',
            
            // Address (removed street_type)
            'street_number' => 'nullable|string|max:20',
            'street_name' => 'required|string|max:255',
            'unit_number' => 'nullable|string|max:20',
            'suburb' => 'required|string|max:100',
            'state' => 'required|string|max:50',
            'postcode' => 'required|string|max:10',
            
            // Details (changed building_size to unit_size)
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'parking_spaces' => 'nullable|integer|min:0',
            'land_size' => 'nullable|numeric|min:0',
            'unit_size' => 'nullable|numeric|min:0',
            
            // Pricing
            'price' => 'nullable|numeric|min:0',
            'rent_per_week' => 'nullable|numeric|min:0',
            'bond_weeks' => 'nullable|integer|min:1|max:52',
            'price_text' => 'nullable|string|max:255',
            
            // Availability
            'available_from' => 'nullable|date',
            'status' => 'required|in:draft,active',

            'condition' => 'required|string',
            'storage' => 'required|string',
            
            // Files
            'floorplan' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            
            // Agents
            'agents' => 'nullable|array',
            'agents.*' => 'exists:agents,id',
        ]);

        // Update full address (without street_type)
        $addressParts = array_filter([
            $validated['unit_number'] ?? null,
            $validated['street_number'] ?? null,
            $validated['street_name'],
            $validated['suburb'],
            $validated['state'],
            $validated['postcode'],
        ]);
        $validated['full_address'] = implode(' ', $addressParts);

        // Map unit_size to building_size for database compatibility
        if (isset($validated['unit_size'])) {
            $validated['building_size'] = $validated['unit_size'];
            unset($validated['unit_size']);
        }

        // Update property
        $property->update($validated);

        // Handle floorplan upload
        if ($request->hasFile('floorplan')) {
            // Delete old floorplan
            if ($property->floorplan_path) {
                Storage::disk('public')->delete($property->floorplan_path);
            }
            
            $path = $request->file('floorplan')->store('properties/floorplans', 'public');
            $property->update(['floorplan_path' => $path]);
        }

        // Handle new property images
        if ($request->hasFile('images')) {
            $currentMaxOrder = $property->images()->max('sort_order') ?? -1;
            
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('properties/images', 'public');
                
                PropertyImage::create([
                    'property_id' => $property->id,
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'file_type' => $image->getMimeType(),
                    'file_size' => $image->getSize(),
                    'sort_order' => $currentMaxOrder + $index + 1,
                    'is_featured' => false,
                ]);
            }
        }

        // Update agents
        if ($request->has('agents')) {
            $property->agents()->detach();
            foreach ($validated['agents'] as $index => $agentId) {
                $property->agents()->attach($agentId, [
                    'role' => $index === 0 ? 'listing_agent' : 'co_agent',
                    'sort_order' => $index,
                ]);
            }
        }

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Property updated successfully!',
            'property_id' => $property->id,
            'public_url' => route('properties.show', $property->public_url_code),
            'edit_url' => route('agency.properties.edit', $property->id),
            'public_url_code' => $property->public_url_code,
        ]);
    }

    /**
     * Remove the specified property.
     */
    public function destroy(Property $property)
    {
        // $this->authorize('delete', $property);

        // Delete floorplan
        if ($property->floorplan_path) {
            Storage::disk('public')->delete($property->floorplan_path);
        }

        // Delete images
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->file_path);
        }

        $property->delete();

        return redirect()->route('agency.properties.index')
            ->with('success', 'Property deleted successfully!');
    }

    /**
     * Delete a property image.
     */
    public function deleteImage(Property $property, PropertyImage $image)
    {
        // $this->authorize('update', $property);

        if ($image->property_id !== $property->id) {
            abort(403);
        }

        Storage::disk('public')->delete($image->file_path);
        $image->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Set featured image.
     */
    public function setFeaturedImage(Property $property, PropertyImage $image)
    {
        // $this->authorize('update', $property);

        if ($image->property_id !== $property->id) {
            abort(403);
        }

        // Remove featured from all images
        $property->images()->update(['is_featured' => false]);
        
        // Set this as featured
        $image->update(['is_featured' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Upload additional images to existing property.
     */
    public function uploadImages(Request $request, Property $property)
    {
        // $this->authorize('update', $property);

        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,jpg,png|max:5120',
        ]);

        if ($request->hasFile('images')) {
            $currentMaxOrder = $property->images()->max('sort_order') ?? -1;
            
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('properties/images', 'public');
                
                PropertyImage::create([
                    'property_id' => $property->id,
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'file_type' => $image->getMimeType(),
                    'file_size' => $image->getSize(),
                    'sort_order' => $currentMaxOrder + $index + 1,
                    'is_featured' => false,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Images uploaded successfully!',
        ]);
    }

    /**
     * Publish property.
     */
    public function publish(Property $property)
    {
        // $this->authorize('update', $property);

        $property->publish();

        return redirect()->back()
            ->with('success', 'Property published successfully!');
    }

    /**
     * Unpublish property.
     */
    public function unpublish(Property $property)
    {
        // $this->authorize('update', $property);

        $property->unpublish();

        return redirect()->back()
            ->with('success', 'Property unpublished successfully!');
    }

    /**
     * Mark property as sold.
     */
    public function markAsSold(Property $property)
    {
        // $this->authorize('update', $property);

        $property->update([
            'status' => 'sold',
            'sold_at' => now(),
            'is_published' => false,
        ]);

        return redirect()->back()
            ->with('success', 'Property marked as sold!');
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Property $property)
    {
        // $this->authorize('update', $property);

        $property->update([
            'is_featured' => !$property->is_featured,
        ]);

        $message = $property->is_featured 
            ? 'Property marked as featured!' 
            : 'Property removed from featured!';

        return redirect()->back()
            ->with('success', $message);
    }
}