<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Display a listing of all properties from all agencies.
     */
    public function index(Request $request)
    {
        $query = Property::with(['agency', 'images'])
            ->orderBy('created_at', 'desc');

        // Filter by agency
        if ($request->filled('agency_id')) {
            $query->where('agency_id', $request->agency_id);
        }

        // Filter by listing type
        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }

        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by title, address, or property ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('street_address', 'like', "%{$search}%")
                  ->orWhere('suburb', 'like', "%{$search}%")
                  ->orWhere('property_id', 'like', "%{$search}%");
            });
        }

        // Filter by price range (for sale properties)
        if ($request->filled('min_price')) {
            $query->where('sale_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('sale_price', '<=', $request->max_price);
        }

        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Get all agencies for filter dropdown
        $agencies = Agency::where('status', 'approved')
            ->orderBy('agency_name')
            ->get();

        $properties = $query->paginate(20)->withQueryString();

        return view('admin.properties.index', compact('properties', 'agencies'));
    }

    /**
     * Display the specified property.
     */
    public function show(Property $property)
    {
        $property->load(['agency', 'images']);

        return view('admin.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified property.
     */
    public function edit(Property $property)
    {
        $agencies = Agency::where('status', 'approved')
            ->orderBy('agency_name')
            ->get();

        return view('admin.properties.edit', compact('property', 'agencies'));
    }

    /**
     * Update the specified property.
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,pending,sold,rented,withdrawn',
            'featured' => 'boolean',
            'verified' => 'boolean',
            'admin_notes' => 'nullable|string|max:1000',
            'agency_id' => 'nullable|exists:agencies,id',
        ]);

        // Handle checkbox values (they won't be in request if unchecked)
        $validated['featured'] = $request->has('featured') ? true : false;
        $validated['verified'] = $request->has('verified') ? true : false;

        $property->update($validated);

        return redirect()
            ->route('admin.properties.show', $property)
            ->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified property.
     */
    public function destroy(Property $property)
    {
        // Delete associated images
        foreach ($property->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        $property->delete();

        return redirect()
            ->route('admin.properties.index')
            ->with('success', 'Property deleted successfully.');
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Property $property)
    {
        $property->update([
            'featured' => !$property->featured
        ]);

        return back()->with('success', 'Featured status updated.');
    }

    /**
     * Toggle verified status.
     */
    public function toggleVerified(Property $property)
    {
        $property->update([
            'verified' => !$property->verified
        ]);

        return back()->with('success', 'Verified status updated.');
    }

    /**
     * Bulk update properties status.
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'property_ids' => 'required|array',
            'property_ids.*' => 'exists:properties,id',
            'action' => 'required|in:activate,deactivate,feature,unfeature,verify,unverify,delete',
        ]);

        $properties = Property::whereIn('id', $validated['property_ids']);

        switch ($validated['action']) {
            case 'activate':
                $properties->update(['status' => 'active']);
                $message = 'Properties activated successfully.';
                break;
            case 'deactivate':
                $properties->update(['status' => 'withdrawn']);
                $message = 'Properties deactivated successfully.';
                break;
            case 'feature':
                $properties->update(['featured' => true]);
                $message = 'Properties featured successfully.';
                break;
            case 'unfeature':
                $properties->update(['featured' => false]);
                $message = 'Properties unfeatured successfully.';
                break;
            case 'verify':
                $properties->update(['verified' => true]);
                $message = 'Properties verified successfully.';
                break;
            case 'unverify':
                $properties->update(['verified' => false]);
                $message = 'Properties unverified successfully.';
                break;
            case 'delete':
                foreach ($properties->get() as $property) {
                    // Delete images
                    foreach ($property->images as $image) {
                        if (Storage::disk('public')->exists($image->image_path)) {
                            Storage::disk('public')->delete($image->image_path);
                        }
                        $image->delete();
                    }
                    $property->delete();
                }
                $message = 'Properties deleted successfully.';
                break;
        }

        return back()->with('success', $message);
    }

    /**
     * Export properties data.
     */
    public function export(Request $request)
    {
        $query = Property::with(['agency']);

        // Apply same filters as index
        if ($request->filled('agency_id')) {
            $query->where('agency_id', $request->agency_id);
        }
        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $properties = $query->get();

        // Generate CSV
        $filename = 'properties_export_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($properties) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'Property ID', 'Title', 'Agency', 'Listing Type', 'Property Type',
                'Status', 'Bedrooms', 'Bathrooms', 'Parking', 'Price',
                'Address', 'Suburb', 'State', 'Postcode', 'Featured', 'Verified',
                'Created At'
            ]);

            // CSV Data
            foreach ($properties as $property) {
                fputcsv($file, [
                    $property->property_id,
                    $property->title,
                    $property->agency->agency_name ?? 'N/A',
                    ucfirst($property->listing_type),
                    $property->property_type,
                    ucfirst($property->status),
                    $property->bedrooms,
                    $property->bathrooms,
                    $property->parking_spaces,
                    $property->listing_type === 'sale' ? $property->sale_price : $property->rent_amount,
                    $property->street_address,
                    $property->suburb,
                    $property->state,
                    $property->postcode,
                    $property->featured ? 'Yes' : 'No',
                    $property->verified ? 'Yes' : 'No',
                    $property->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show statistics dashboard.
     */
    public function statistics()
    {
        $stats = [
            'total_properties' => Property::count(),
            'active_properties' => Property::where('status', 'active')->count(),
            'featured_properties' => Property::where('featured', true)->count(),
            'properties_for_sale' => Property::where('listing_type', 'sale')->count(),
            'properties_for_rent' => Property::where('listing_type', 'rent')->count(),
            'sold_properties' => Property::where('status', 'sold')->count(),
            'rented_properties' => Property::where('status', 'rented')->count(),
            'pending_properties' => Property::where('status', 'pending')->count(),
        ];

        // Properties by agency
        $propertiesByAgency = Property::selectRaw('agency_id, count(*) as count')
            ->groupBy('agency_id')
            ->with('agency')
            ->get()
            ->map(function($item) {
                return [
                    'agency' => $item->agency->agency_name ?? 'Unknown',
                    'count' => $item->count
                ];
            });

        // Recent properties
        $recentProperties = Property::with('agency')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.properties.statistics', compact('stats', 'propertiesByAgency', 'recentProperties'));
    }
}