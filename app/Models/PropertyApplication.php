<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'agency_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'move_in_date',
        'current_address',
        'employment_status',
        'employer_name',
        'annual_income',
        'number_of_occupants',
        'has_pets',
        'pet_details',
        'references',
        'additional_information',
        'status',
        'reviewed_at',
        'reviewed_by',
        'rejection_reason',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'annual_income' => 'decimal:2',
        'has_pets' => 'boolean',
        'references' => 'array',
        'reviewed_at' => 'datetime',
    ];

    // Relationships
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'reviewing' => 'bg-blue-100 text-blue-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Property applications (for rental properties)
     */
    public function applications()
    {
        return $this->hasMany(PropertyApplication::class);
    }

    /**
     * Pending applications
     */
    public function pendingApplications()
    {
        return $this->hasMany(PropertyApplication::class)->where('status', 'pending');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}