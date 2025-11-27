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
        'listing_agent_id',
        'property_manager_id',
        'property_code',
        'property_type',
        'listing_type',
        'status',
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
        'bedrooms',
        'bathrooms',
        'parking_spaces',
        'garages',
        'land_area',
        'land_area_unit',
        'floor_area',
        'floor_area_unit',
        'year_built',
        'price',
        'price_min',
        'price_max',
        'price_display',
        'price_text',
        'rent_per_week',
        'rent_per_month',
        'bond_amount',
        'available_from',
        'lease_term_months',
        'headline',
        'description',
        'features',
        'indoor_features',
        'outdoor_features',
        'video_url',
        'virtual_tour_url',
        'is_featured',
        'view_count',
        'enquiry_count',
        'inspection_count',
        'auction_date',
        'auction_venue',
        'sale_date',
        'sale_price',
        'inspection_times',
        'listed_at',
        'unlisted_at',
        'sold_at',
        'leased_at',
        'council_rates',
        'strata_fees',
        'water_rates',
        'zoning',
        'slug',
        'is_published',
        'published_at',
        'metadata',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'price' => 'decimal:2',
        'price_min' => 'decimal:2',
        'price_max' => 'decimal:2',
        'price_display' => 'boolean',
        'rent_per_week' => 'decimal:2',
        'rent_per_month' => 'decimal:2',
        'bond_amount' => 'decimal:2',
        'available_from' => 'date',
        'sale_price' => 'decimal:2',
        'land_area' => 'decimal:2',
        'floor_area' => 'decimal:2',
        'features' => 'array',
        'indoor_features' => 'array',
        'outdoor_features' => 'array',
        'inspection_times' => 'array',
        'metadata' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'auction_date' => 'datetime',
        'listed_at' => 'date',
        'unlisted_at' => 'date',
        'sold_at' => 'date',
        'leased_at' => 'date',
        'sale_date' => 'date',
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'full_address',
        'short_address',
        'display_price',
        'is_active',
    ];

    // Relationships
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function listingAgent()
    {
        return $this->belongsTo(Agent::class, 'listing_agent_id');
    }

    public function propertyManager()
    {
        return $this->belongsTo(Agent::class, 'property_manager_id');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function featuredImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_featured', true);
    }

    public function enquiries()
    {
        return $this->hasMany(PropertyEnquiry::class);
    }

    public function activities()
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    // Accessors
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->unit_number ? "Unit {$this->unit_number}," : null,
            $this->street_number,
            $this->street_name,
            $this->street_type,
            $this->suburb,
            $this->state,
            $this->postcode,
        ]);

        return implode(' ', $parts);
    }

    public function getShortAddressAttribute()
    {
        $parts = array_filter([
            $this->street_number,
            $this->street_name,
            $this->suburb,
        ]);

        return implode(' ', $parts);
    }

    public function getDisplayPriceAttribute()
    {
        if (!$this->price_display) {
            return $this->price_text ?? 'Contact Agent';
        }

        if ($this->listing_type === 'rent') {
            if ($this->rent_per_week) {
                return '$' . number_format($this->rent_per_week, 0) . ' per week';
            }
            if ($this->rent_per_month) {
                return '$' . number_format($this->rent_per_month, 0) . ' per month';
            }
        }

        if ($this->price_min && $this->price_max) {
            return '$' . number_format($this->price_min, 0) . ' - $' . number_format($this->price_max, 0);
        }

        if ($this->price) {
            return '$' . number_format($this->price, 0);
        }

        return $this->price_text ?? 'POA';
    }

    public function getIsActiveAttribute()
    {
        return in_array($this->status, ['active', 'under_contract']);
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featuredImage) {
            return \Storage::disk('public')->url($this->featuredImage->file_path);
        }

        // Default property placeholder
        return "https://ui-avatars.com/api/?name=" . urlencode($this->short_address) . 
               "&size=800&background=4F46E5&color=fff&bold=true";
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['active', 'under_contract']);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeForSale($query)
    {
        return $query->where('listing_type', 'sale');
    }

    public function scopeForRent($query)
    {
        return $query->where('listing_type', 'rent');
    }

    public function scopeInSuburb($query, $suburb)
    {
        return $query->where('suburb', 'like', "%{$suburb}%");
    }

    public function scopePriceBetween($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeWithBedrooms($query, $bedrooms)
    {
        return $query->where('bedrooms', '>=', $bedrooms);
    }

    public function scopeForAgency($query, $agencyId)
    {
        return $query->where('agency_id', $agencyId);
    }

    public function scopeByAgent($query, $agentId)
    {
        return $query->where('listing_agent_id', $agentId);
    }

    // Methods
    public function publish()
    {
        $this->update([
            'is_published' => true,
            'published_at' => now(),
            'status' => 'active',
            'listed_at' => $this->listed_at ?? now(),
        ]);

        ActivityLog::log("Property published: {$this->full_address}", $this->agency);
    }

    public function unpublish()
    {
        $this->update([
            'is_published' => false,
            'status' => 'off_market',
            'unlisted_at' => now(),
        ]);

        ActivityLog::log("Property unpublished: {$this->full_address}", $this->agency);
    }

    public function markAsSold($salePrice = null, $saleDate = null)
    {
        $this->update([
            'status' => 'sold',
            'sale_price' => $salePrice ?? $this->price,
            'sale_date' => $saleDate ?? now(),
            'sold_at' => now(),
            'is_published' => false,
        ]);

        ActivityLog::log("Property sold: {$this->full_address} for $" . number_format($this->sale_price, 0), $this->agency);
    }

    public function markAsLeased($leaseDate = null)
    {
        $this->update([
            'status' => 'leased',
            'leased_at' => $leaseDate ?? now(),
            'is_published' => false,
        ]);

        ActivityLog::log("Property leased: {$this->full_address}", $this->agency);
    }

    public function incrementViews()
    {
        $this->increment('view_count');
    }

    public function incrementEnquiries()
    {
        $this->increment('enquiry_count');
    }

    public function incrementInspections()
    {
        $this->increment('inspection_count');
    }

    public function generatePropertyCode()
    {
        $agency = $this->agency;
        $prefix = strtoupper(substr($agency->agency_name, 0, 3));
        $count = $agency->properties()->count() + 1;
        
        return $prefix . '-' . $this->listing_type[0] . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    public function generateSlug()
    {
        $baseSlug = Str::slug($this->short_address);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            if (!$property->property_code) {
                $property->property_code = $property->generatePropertyCode();
            }
            
            if (!$property->slug) {
                $property->slug = $property->generateSlug();
            }

            if (!$property->listed_at && $property->is_published) {
                $property->listed_at = now();
            }
        });

        static::created(function ($property) {
            ActivityLog::log(
                "New property added: {$property->full_address}",
                $property->agency,
                ['property_id' => $property->id, 'property_code' => $property->property_code]
            );
        });

        static::updated(function ($property) {
            if ($property->isDirty('status')) {
                $oldStatus = $property->getOriginal('status');
                ActivityLog::log(
                    "Property status changed: {$property->full_address} ({$oldStatus} → {$property->status})",
                    $property->agency
                );
            }
        });

        static::deleted(function ($property) {
            ActivityLog::log(
                "Property removed: {$property->full_address}",
                $property->agency,
                ['property_id' => $property->id]
            );
        });
    }
}