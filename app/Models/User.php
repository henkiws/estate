<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'position',
        'agency_id',
        'is_admin',
        'preferred_state',
        'profile_completed',
        'profile_current_step',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'profile_completed' => 'boolean',
        'profile_current_step' => 'integer',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the agency that owns the user.
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Get the agency contact record for this user.
     */
    public function agencyContact()
    {
        return $this->hasOne(AgencyContact::class);
    }

    /**
     * Get the agent profile for this user.
     */
    public function agentProfile()
    {
        return $this->hasOne(Agent::class);
    }

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is an agency
     */
    public function isAgency(): bool
    {
        return $this->hasRole('agency');
    }

    /**
     * Check if user is an agent
     */
    public function isAgent(): bool
    {
        return $this->hasRole('agent');
    }

    /**
     * Get user's full role name
     */
    public function getRoleName(): string
    {
        return $this->roles->first()?->name ?? 'unknown';
    }

    /**
     * Check if user belongs to an agency
     */
    public function belongsToAgency(): bool
    {
        return !is_null($this->agency_id);
    }

    /**
     * Get full phone number with format
     */
    public function getFormattedPhone(): ?string
    {
        return $this->phone ? preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2 $3', $this->phone) : null;
    }

    /**
     * Get properties saved by this user
     */
    public function savedProperties()
    {
        return $this->belongsToMany(Property::class, 'saved_properties')
            ->withTimestamps();
    }

    /**
     * Get property applications submitted by this user
     */
    public function propertyApplications()
    {
        return $this->hasMany(PropertyApplication::class);
    }

    /**
     * Get enquiries made by this user
     */
    public function propertyEnquiries()
    {
        return $this->hasMany(PropertyEnquiry::class);
    }

    /**
     * Get the properties that this user has saved (direct relationship)
     */
    public function favoriteProperties()
    {
        return $this->belongsToMany(Property::class, 'saved_properties')
            ->withTimestamps();
    }

    /**
     * Check if user has saved a property
     */
    public function hasSavedProperty($propertyId)
    {
        return $this->savedProperties()->where('property_id', $propertyId)->exists();
    }

    /**
     * Toggle save property
     */
    public function toggleSaveProperty($propertyId)
    {
        if ($this->hasSavedProperty($propertyId)) {
            $this->savedProperties()->detach($propertyId);
            return false; // Unsaved
        } else {
            $this->savedProperties()->attach($propertyId);
            return true; // Saved
        }
    }

     public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function incomes(): HasMany
    {
        return $this->hasMany(UserIncome::class);
    }

    public function employments(): HasMany
    {
        return $this->hasMany(UserEmployment::class);
    }

    public function pets(): HasMany
    {
        return $this->hasMany(UserPet::class);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(UserVehicle::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

    public function references(): HasMany
    {
        return $this->hasMany(UserReference::class);
    }

    public function identifications(): HasMany
    {
        return $this->hasMany(UserIdentification::class);
    }

    public function needsProfileCompletion(): bool
    {
        if (!$this->profile) {
            return true;
        }

        return !$this->profile->isComplete();
    }

    public function hasRoleUser(): bool
    {
        // Assuming you're using Spatie Laravel Permission
        return $this->hasRole('user');
    }

    /**
     * Get tickets assigned to this user (for staff/admin)
     */
    public function assignedTickets()
    {
        return $this->hasMany(SupportTicket::class, 'assigned_to');
    }
}