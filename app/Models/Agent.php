<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'agency_id',
        'user_id',
        'agent_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'mobile',
        'license_number',
        'license_expiry',
        'position',
        'employment_type',
        'commission_rate',
        'bio',
        'photo',
        'specializations',
        'languages',
        'social_media',
        'address_line1',
        'address_line2',
        'suburb',
        'state',
        'postcode',
        'country',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'status',
        'started_at',
        'ended_at',
        'is_featured',
        'is_accepting_new_listings',
        'metadata',
    ];

    protected $casts = [
        'license_expiry' => 'date',
        'started_at' => 'date',
        'ended_at' => 'date',
        'commission_rate' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_accepting_new_listings' => 'boolean',
        'specializations' => 'array',
        'languages' => 'array',
        'social_media' => 'array',
        'metadata' => 'array',
    ];

    protected $appends = [
        'full_name',
        'initials',
        'is_active',
    ];

    // Relationships
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'listing_agent_id');
    }

    public function listings()
    {
        return $this->hasMany(Property::class, 'listing_agent_id')
            ->where('status', 'active');
    }

    public function activities()
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getInitialsAttribute()
    {
        return strtoupper(
            substr($this->first_name, 0, 1) . 
            substr($this->last_name, 0, 1)
        );
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'active' && 
               $this->user && 
               $this->user->is_active;
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return \Storage::disk('public')->url($this->photo);
        }
        
        // Default avatar using UI Avatars
        return "https://ui-avatars.com/api/?name=" . urlencode($this->full_name) . 
               "&size=200&background=4F46E5&color=fff&bold=true";
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeAcceptingListings($query)
    {
        return $query->where('is_accepting_new_listings', true);
    }

    public function scopeForAgency($query, $agencyId)
    {
        return $query->where('agency_id', $agencyId);
    }

    // Methods
    public function activate()
    {
        $this->update(['status' => 'active']);
        
        if ($this->user) {
            $this->user->update(['is_active' => true]);
        }
        
        ActivityLog::log("Agent activated: {$this->full_name}", $this->agency);
    }

    public function deactivate()
    {
        $this->update(['status' => 'inactive']);
        
        if ($this->user) {
            $this->user->update(['is_active' => false]);
        }
        
        ActivityLog::log("Agent deactivated: {$this->full_name}", $this->agency);
    }

    public function generateAgentCode()
    {
        $agency = $this->agency;
        $prefix = strtoupper(substr($agency->agency_name, 0, 3));
        $count = $agency->agents()->count() + 1;
        
        return $prefix . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function hasExpiredLicense()
    {
        return $this->license_expiry && $this->license_expiry->isPast();
    }

    public function getPerformanceStats()
    {
        return [
            'total_properties' => $this->properties()->count(),
            'active_listings' => $this->listings()->count(),
            'sold_properties' => $this->properties()->where('status', 'sold')->count(),
            'leased_properties' => $this->properties()->where('status', 'leased')->count(),
        ];
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($agent) {
            if (!$agent->agent_code) {
                $agent->agent_code = $agent->generateAgentCode();
            }
            
            if (!$agent->status) {
                $agent->status = 'active';
            }
        });

        static::created(function ($agent) {
            ActivityLog::log(
                "New agent added: {$agent->full_name}",
                $agent->agency,
                ['agent_id' => $agent->id, 'agent_code' => $agent->agent_code]
            );
        });

        static::updated(function ($agent) {
            if ($agent->isDirty('status')) {
                $oldStatus = $agent->getOriginal('status');
                ActivityLog::log(
                    "Agent status changed: {$agent->full_name} ({$oldStatus} → {$agent->status})",
                    $agent->agency
                );
            }
        });

        static::deleted(function ($agent) {
            ActivityLog::log(
                "Agent removed: {$agent->full_name}",
                $agent->agency,
                ['agent_id' => $agent->id]
            );
        });
    }
}