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
        
        // Old comprehensive fields (keep for backward compatibility)
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'current_address',
        'has_pets',
        'pet_details',
        'employment_status',
        'employer_name',
        'job_title',
        'annual_income',
        'references',
        'documents',
        'inspection_confirmed',
        'inspection_date',

        'property_inspection',      // ← Add this
        'inspection_date',           // ← Add this
        
        // New simplified fields (from your blade form)
        'move_in_date',
        'lease_term', // Renamed from lease_duration
        'lease_duration', // Keep old name for BC
        'number_of_occupants',
        'occupants_details', // NEW: JSON array for additional occupants
        'special_requests', // NEW: Special requests field
        'notes', // NEW: Additional notes (renamed from additional_information)
        'additional_information', // Keep old name for BC
        
        // Admin/Agency fields
        'agency_notes',
        'reviewed_by',
        'submitted_at',
        'reviewed_at',
        'withdrawn_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'move_in_date' => 'date',
        'inspection_date' => 'date',
        'has_pets' => 'boolean',
        'inspection_confirmed' => 'boolean',
        'annual_income' => 'decimal:2',
        'lease_duration' => 'integer',
        'lease_term' => 'integer',
        'number_of_occupants' => 'integer',
        'references' => 'array',
        'documents' => 'array',
        'inspection_date' => 'date',
        'occupants_details' => 'array', // NEW
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'withdrawn_at' => 'datetime',
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
     * Get the reviewer (admin/agency user)
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get co-applicants (if using separate table)
     */
    public function coApplicants()
    {
        return $this->hasMany(CoApplicant::class);
    }

    /**
     * Get full name of applicant
     */
    public function getFullNameAttribute()
    {
        // Try to get from application fields first
        if ($this->first_name && $this->last_name) {
            return "{$this->first_name} {$this->last_name}";
        }
        
        // Fallback to user's name
        return $this->user ? $this->user->name : 'N/A';
    }

    /**
     * Get applicant email
     */
    public function getApplicantEmailAttribute()
    {
        return $this->email ?? $this->user?->email;
    }

    /**
     * Get applicant phone
     */
    public function getApplicantPhoneAttribute()
    {
        return $this->phone ?? $this->user?->phone;
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'draft' => 'gray',
            'pending' => 'yellow',
            'under_review' => 'blue',
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
            'draft' => 'Draft',
            'pending' => 'Pending Review',
            'under_review' => 'Under Review',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'withdrawn' => 'Withdrawn',
            default => ucfirst($this->status),
        };
    }

    /**
     * Check if application is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if application is a draft
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if application is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if application is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if application is withdrawn
     */
    public function isWithdrawn(): bool
    {
        return $this->status === 'withdrawn';
    }
    
    /**
     * Check if user can withdraw this application
     */
    public function canWithdraw(): bool
    {
        return in_array($this->status, ['pending', 'under_review', 'draft']);
    }

    /**
     * Check if user can edit this application
     */
    public function canEdit(): bool
    {
        return in_array($this->status, ['draft', 'pending']);
    }

    /**
     * Get how many days ago the application was created
     */
    public function getDaysAgo(): string
    {
        $days = $this->created_at->diffInDays(now());
        
        if ($days === 0) {
            return 'Today';
        } elseif ($days === 1) {
            return 'Yesterday';
        } elseif ($days < 7) {
            return $days . ' days ago';
        } elseif ($days < 30) {
            $weeks = floor($days / 7);
            return $weeks . ($weeks === 1 ? ' week ago' : ' weeks ago');
        } else {
            return $this->created_at->format('M j, Y');
        }
    }

    /**
     * Scope to get pending applications
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get draft applications
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
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
            'reviewed_by' => auth()->id(),
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
            'reviewed_by' => auth()->id(),
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
            'withdrawn_at' => now(),
        ]);
    }

    /**
     * Check if property was inspected
     */
    public function hasInspectedProperty(): bool
    {
        return $this->property_inspection === 'yes';
    }

    /**
     * Get formatted inspection status
     */
    public function getInspectionStatusAttribute(): string
    {
        if ($this->property_inspection === 'yes') {
            return $this->inspection_date 
                ? 'Inspected on ' . $this->inspection_date->format('M d, Y')
                : 'Inspected';
        }
        
        return 'Not inspected';
    }

    /**
     * Get inspection status badge color
     */
    public function getInspectionBadgeColorAttribute(): string
    {
        return $this->property_inspection === 'yes' 
            ? 'bg-green-100 text-green-800' 
            : 'bg-gray-100 text-gray-800';
    }

    /**
    * Get tenant record if application was converted
    */
    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }

    /**
     * Check if application has been converted to tenant
     */
    public function hasBeenConvertedToTenant()
    {
        return $this->tenant()->exists();
    }
}