<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// ============================================
// 1. Agency Model (Main)
// ============================================
class Agency extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'agency_name',
        'trading_name',
        'abn',
        'acn',
        'business_type',
        'license_number',
        'license_holder_name',
        'license_expiry_date',
        'business_address',
        'state',
        'postcode',
        'business_phone',
        'business_email',
        'website_url',
        'status',
        'verified_at',
        'onboarding_completed_at',
        'verified_by',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'license_expiry_date' => 'date',
    ];

    // Relationships
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(AgencyContact::class);
    }

    public function primaryContact(): HasOne
    {
        return $this->hasOne(AgencyContact::class)->where('is_primary', true);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(AgencyDocument::class);
    }

    public function branding(): HasOne
    {
        return $this->hasOne(AgencyBranding::class);
    }

    public function services(): HasOne
    {
        return $this->hasOne(AgencyService::class);
    }

    public function billing(): HasOne
    {
        return $this->hasOne(AgencyBilling::class);
    }

    public function compliance(): HasOne
    {
        return $this->hasOne(AgencyCompliance::class);
    }

    public function settings(): HasOne
    {
        return $this->hasOne(AgencySetting::class);
    }

    public function agents(): HasMany
    {
        return $this->hasMany(Agent::class);
    }

    /**
     * Get all properties for this agency
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }

    public function scopeByState($query, string $state)
    {
        return $query->where('state', $state);
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    public function getTotalAgents(): int
    {
        return $this->agents()->count();
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class)->latest();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function documentRequirement()
    {
        return $this->hasOne(AgencyDocumentRequirement::class);
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscription && $this->subscription->isActive();
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function canAccessFullFeatures(): bool
    {
        return $this->status === 'active' && $this->hasActiveSubscription();
    }

    public function needsSubscription(): bool
    {
        return $this->status === 'approved' && !$this->hasActiveSubscription();
    }
    /**
     * Get all document requirements for the agency
     */
    public function documentRequirements(): HasMany
    {
        return $this->hasMany(AgencyDocumentRequirement::class);
    }
}