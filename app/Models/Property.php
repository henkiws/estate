<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'agency_id',
        'property_code',
        'property_type',
        'listing_type',
        'status',
        'storage',
        'condition',
        
        // Address
        'street_number',
        'street_name',
        'street_type',
        'unit_number',
        'suburb',
        'state',
        'postcode',
        'country',
        'latitude',
        'longitude',
        'full_address',
        
        // Specifications
        'bedrooms',
        'bathrooms',
        'parking_spaces',
        'land_size',
        'land_size_unit',
        'building_size',
        'building_size_unit',
        'year_built',
        
        // Pricing
        'price',
        'price_text',
        'rent_per_week',
        'rent_per_month',
        'bond_amount',
        'bond_weeks',
        'available_from',
        'lease_term_months',
        
        // Description
        'headline',
        'description',
        'floorplan_path',
        'features',
        'indoor_features',
        'outdoor_features',
        
        // Marketing
        'video_url',
        'virtual_tour_url',
        'is_featured',
        'view_count',
        'enquiry_count',
        'inspection_count',
        
        // Auction/Sale
        'auction_date',
        'auction_venue',
        'sale_date',
        'sale_price',
        
        // Inspections
        'inspection_times',
        
        // Listing dates
        'listed_at',
        'unlisted_at',
        'sold_at',
        'leased_at',
        
        // Additional
        'council_rates',
        'strata_fees',
        'water_rates',
        'zoning',
        
        // SEO
        'slug',
        'public_url_code',
        'is_published',
        'published_at',
        
        'metadata',
    ];

    protected $casts = [
        'features' => 'array',
        'indoor_features' => 'array',
        'outdoor_features' => 'array',
        'inspection_times' => 'array',
        'metadata' => 'array',
        'available_from' => 'date',
        'auction_date' => 'datetime',
        'sale_date' => 'date',
        'listed_at' => 'date',
        'unlisted_at' => 'date',
        'sold_at' => 'date',
        'leased_at' => 'date',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'price' => 'decimal:2',
        'rent_per_week' => 'decimal:2',
        'rent_per_month' => 'decimal:2',
        'bond_amount' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    protected $appends = [
        'full_address',
        'short_address',
        'display_price',
        'is_active',
        'public_url',
        'edit_url',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            // Generate property code if not set
            if (empty($property->property_code)) {
                $property->property_code = 'PROP-' . strtoupper(Str::random(8));
            }
            
            // Generate public URL code
            if (empty($property->public_url_code)) {
                $property->public_url_code = Str::random(12);
            }
            
            // Generate slug if not set
            if (empty($property->slug)) {
                $baseSlug = Str::slug($property->street_name . ' ' . $property->suburb);
                $slug = $baseSlug;
                $counter = 1;
                
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                
                $property->slug = $slug;
            }
            
            // Calculate bond if rent is set and bond weeks is set
            if ($property->rent_per_week && $property->bond_weeks) {
                $property->bond_amount = $property->rent_per_week * $property->bond_weeks;
            }
        });

        static::updating(function ($property) {
            // Recalculate bond if rent or bond_weeks changed
            if ($property->isDirty(['rent_per_week', 'bond_weeks']) && $property->rent_per_week && $property->bond_weeks) {
                $property->bond_amount = $property->rent_per_week * $property->bond_weeks;
            }
        });
    }

    /**
     * Relationships
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'property_agents')
                    ->withPivot('role', 'sort_order')
                    ->withTimestamps()
                    ->orderBy('property_agents.sort_order');
    }

    public function listingAgent()
    {
        return $this->belongsToMany(Agent::class, 'property_agents')
                    ->wherePivot('role', 'listing_agent')
                    ->withPivot('sort_order')
                    ->withTimestamps()
                    ->orderBy('property_agents.sort_order')
                    ->limit(1);
    }

    public function propertyManagers()
    {
        return $this->belongsToMany(Agent::class, 'property_agents')
                    ->wherePivot('role', 'property_manager')
                    ->withPivot('sort_order')
                    ->withTimestamps()
                    ->orderBy('property_agents.sort_order');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function featuredImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_featured', true);
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForRent($query)
    {
        return $query->where('listing_type', 'rent');
    }

    public function scopeForSale($query)
    {
        return $query->where('listing_type', 'sale');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Accessors
     */
    public function getFormattedPriceAttribute()
    {
        if ($this->listing_type === 'rent' && $this->rent_per_week) {
            return '$' . number_format($this->rent_per_week, 0) . ' per week';
        } elseif ($this->price) {
            return '$' . number_format($this->price, 0);
        }
        return 'Contact for price';
    }

    public function getFormattedBondAttribute()
    {
        if ($this->bond_amount) {
            return '$' . number_format($this->bond_amount, 0);
        }
        return null;
    }

    /**
     * Get the public URL for the property
     */
    public function getPublicUrlAttribute()
    {
        return route('properties.show', $this->public_url_code);
    }

    /**
     * Get the edit URL for the property
     */
    public function getEditUrlAttribute()
    {
        return route('agency.properties.edit', $this->id);
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('view_count');
    }

    /**
     * Increment enquiry count
     */
    public function incrementEnquiries()
    {
        $this->increment('enquiry_count');
    }

    /**
     * Increment inspection count
     */
    public function incrementInspections()
    {
        $this->increment('inspection_count');
    }
    
    public function getBedroomsBathroomsTextAttribute()
    {
        $parts = [];
        if ($this->bedrooms) {
            $parts[] = $this->bedrooms . ' bed';
        }
        if ($this->bathrooms) {
            $parts[] = $this->bathrooms . ' bath';
        }
        if ($this->parking_spaces) {
            $parts[] = $this->parking_spaces . ' car';
        }
        return implode(', ', $parts);
    }

    /**
     * Methods
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function incrementEnquiryCount()
    {
        $this->increment('enquiry_count');
    }

    public function publish()
    {
        $this->update([
            'is_published' => true,
            'published_at' => now(),
            'status' => 'active',
        ]);
    }

    public function unpublish()
    {
        $this->update([
            'is_published' => false,
            'status' => 'draft',
        ]);
    }

    /**
     * Get full formatted address
     */
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->unit_number ? "Unit {$this->unit_number}," : null,
            $this->street_number ?? null,
            $this->street_name ?? null,
            $this->street_type ?? null,
            $this->suburb ?? null,
            $this->state ?? null,
            $this->postcode ?? null,
        ]);

        return !empty($parts) ? implode(' ', $parts) : 'Address not set';
    }

    /**
     * Get short address (street and suburb only)
     */
    public function getShortAddressAttribute()
    {
        $parts = array_filter([
            $this->street_number ?? null,
            $this->street_name ?? null,
            $this->suburb ?? null,
        ]);

        return !empty($parts) ? implode(' ', $parts) : 'Address not set';
    }

    /**
     * Get formatted display price
     */
    public function getDisplayPriceAttribute()
    {
        // If price display is disabled, show price text or default
        if (!$this->price_display) {
            return $this->price_text ?? 'Contact Agent';
        }

        // Handle rental properties
        if ($this->listing_type === 'rent') {
            if ($this->rent_per_week && $this->rent_per_week > 0) {
                return '$' . number_format($this->rent_per_week, 0) . ' per week';
            }
            if ($this->rent_per_month && $this->rent_per_month > 0) {
                return '$' . number_format($this->rent_per_month, 0) . ' per month';
            }
            return $this->price_text ?? 'Contact Agent';
        }

        // Handle price ranges
        if ($this->price_min && $this->price_max && $this->price_min > 0 && $this->price_max > 0) {
            return '$' . number_format($this->price_min, 0) . ' - $' . number_format($this->price_max, 0);
        }

        // Handle single price
        if ($this->price && $this->price > 0) {
            return '$' . number_format($this->price, 0);
        }

        // Fallback to price text or POA
        return $this->price_text ?? 'POA';
    }

    /**
     * Check if property is active
     */
    public function getIsActiveAttribute()
    {
        // Add null check for status
        if (!$this->status) {
            return false;
        }
        
        return in_array($this->status, ['active', 'under_contract']);
    }

    /**
     * Get featured image URL
     */
    public function getFeaturedImageUrlAttribute()
    {
        // Check if featuredImage relationship is loaded and exists
        if ($this->relationLoaded('featuredImage') && $this->featuredImage) {
            return \Storage::disk('public')->url($this->featuredImage->file_path);
        }

        // Fallback: Check for any image
        if ($this->relationLoaded('images') && $this->images->isNotEmpty()) {
            return \Storage::disk('public')->url($this->images->first()->file_path);
        }

        // Default property placeholder
        $addressText = $this->short_address !== 'Address not set' 
            ? $this->short_address 
            : 'Property';
            
        return "https://ui-avatars.com/api/?name=" . urlencode($addressText) . 
            "&size=800&background=4F46E5&color=fff&bold=true";
    }

    /**
     * Get users who saved this property
     */
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_properties')
            ->withTimestamps();
    }

    /**
     * Get applications for this property
     */
    public function applications()
    {
        return $this->hasMany(PropertyApplication::class);
    }

    /**
     * Get enquiries for this property
     */
    public function enquiries()
    {
        return $this->hasMany(PropertyEnquiry::class);
    }

    /**
     * Check if property is saved by a specific user
     */
    public function isSavedBy($userId)
    {
        return $this->savedByUsers()->where('user_id', $userId)->exists();
    }

    /**
     * Get count of users who saved this property
     */
    public function getSavedCountAttribute()
    {
        return $this->savedByUsers()->count();
    }

}