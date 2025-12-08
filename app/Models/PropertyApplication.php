<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'property_id',
        'agency_id',
        'status',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'current_address',
        'move_in_date',
        'number_of_occupants',
        'has_pets',
        'pet_details',
        'employment_status',
        'employer_name',
        'job_title',
        'annual_income',
        'references',
        'additional_information',
        'documents',
        'agency_notes',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'move_in_date' => 'date',
        'has_pets' => 'boolean',
        'annual_income' => 'decimal:2',
        'references' => 'array',
        'documents' => 'array',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who submitted the application
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property for this application
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the agency that manages this property
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Get full name of applicant
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            'withdrawn' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending Review',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'withdrawn' => 'Withdrawn',
            default => 'Unknown',
        };
    }

    /**
     * Scope to get pending applications
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get applications for a specific agency
     */
    public function scopeForAgency($query, $agencyId)
    {
        return $query->where('agency_id', $agencyId);
    }

    /**
     * Scope to get applications for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Mark application as approved
     */
    public function approve($notes = null)
    {
        $this->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'agency_notes' => $notes,
        ]);
    }

    /**
     * Mark application as rejected
     */
    public function reject($notes = null)
    {
        $this->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'agency_notes' => $notes,
        ]);
    }

    /**
     * Mark application as withdrawn
     */
    public function withdraw()
    {
        $this->update([
            'status' => 'withdrawn',
        ]);
    }
}