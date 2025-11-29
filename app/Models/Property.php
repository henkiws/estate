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

    public function applications()
    {
        return $this->hasMany(PropertyApplication::class);
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

    public function getPublicUrlAttribute()
    {
        return route('agency.properties.show', $this->public_url_code);
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
}