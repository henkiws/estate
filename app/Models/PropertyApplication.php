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
        
        // Applicant info
        'full_name',
        'email',
        'phone',
        'current_address',
        'city',
        'state',
        'postcode',
        
        // Employment
        'employment_status',
        'employer_name',
        'job_title',
        'annual_income',
        'employment_length_months',
        
        // References
        'reference_1_name',
        'reference_1_phone',
        'reference_1_relationship',
        'reference_2_name',
        'reference_2_phone',
        'reference_2_relationship',
        
        // Additional
        'number_of_occupants',
        'has_pets',
        'pet_details',
        'preferred_move_in_date',
        'additional_notes',
        
        // Documents
        'id_document_path',
        'income_proof_path',
        'reference_letter_path',
        
        // Status
        'status',
        'agency_notes',
        'reviewed_at',
        'reviewed_by',
        
        // Tracking
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'annual_income' => 'decimal:2',
        'has_pets' => 'boolean',
        'preferred_move_in_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Relationships
     */
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

    /**
     * Scopes
     */
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

    /**
     * Accessors
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'reviewing' => 'blue',
            'approved' => 'green',
            'rejected' => 'red',
            'withdrawn' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Methods
     */
    public function approve($userId)
    {
        $this->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => $userId,
        ]);
    }

    public function reject($userId, $notes = null)
    {
        $this->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => $userId,
            'agency_notes' => $notes,
        ]);
    }
}