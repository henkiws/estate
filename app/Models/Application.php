<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'status',
        'move_in_date',
        'lease_term',
        'number_of_occupants',
        'occupants_details',
        'special_requests',
        'notes',
        'admin_notes',
        'submitted_at',
        'reviewed_at',
        'approved_at',
        'rejected_at',
        'withdrawn_at',
        'rejection_reason',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'occupants_details' => 'array',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'withdrawn_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Scopes
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['submitted', 'under_review']);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['draft', 'submitted', 'under_review']);
    }

    public function scopeCompleted($query)
    {
        return $query->whereIn('status', ['approved', 'rejected', 'withdrawn']);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('property', function ($q) use ($search) {
            $q->where('address', 'like', "%{$search}%")
              ->orWhere('property_code', 'like', "%{$search}%");
        });
    }

    /**
     * Status Check Methods
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    public function isUnderReview(): bool
    {
        return $this->status === 'under_review';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isWithdrawn(): bool
    {
        return $this->status === 'withdrawn';
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['submitted', 'under_review']);
    }

    public function canWithdraw(): bool
    {
        return in_array($this->status, ['draft', 'submitted', 'under_review']);
    }

    public function canEdit(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Status Action Methods
     */
    public function submit(): bool
    {
        if ($this->status !== 'draft') {
            return false;
        }

        $this->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return true;
    }

    public function markUnderReview(): bool
    {
        if ($this->status !== 'submitted') {
            return false;
        }

        $this->update([
            'status' => 'under_review',
            'reviewed_at' => now(),
        ]);

        return true;
    }

    public function approve(): bool
    {
        if (!in_array($this->status, ['submitted', 'under_review'])) {
            return false;
        }

        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return true;
    }

    public function reject(string $reason = null): bool
    {
        if (!in_array($this->status, ['submitted', 'under_review'])) {
            return false;
        }

        $this->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejection_reason' => $reason,
        ]);

        return true;
    }

    public function withdraw(): bool
    {
        if (!$this->canWithdraw()) {
            return false;
        }

        $this->update([
            'status' => 'withdrawn',
            'withdrawn_at' => now(),
        ]);

        return true;
    }

    /**
     * Helper Methods
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'draft' => 'bg-gray-100 text-gray-700',
            'submitted' => 'bg-blue-100 text-blue-700',
            'under_review' => 'bg-orange-100 text-orange-700',
            'approved' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            'withdrawn' => 'bg-gray-100 text-gray-600',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'submitted' => 'Submitted',
            'under_review' => 'Under Review',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'withdrawn' => 'Withdrawn',
            default => ucfirst($this->status),
        };
    }

    public function getTimelineSteps(): array
    {
        return [
            [
                'label' => 'Submitted',
                'completed' => !is_null($this->submitted_at),
                'date' => $this->submitted_at,
            ],
            [
                'label' => 'Under Review',
                'completed' => !is_null($this->reviewed_at),
                'date' => $this->reviewed_at,
            ],
            [
                'label' => $this->isApproved() ? 'Approved' : ($this->isRejected() ? 'Rejected' : 'Decision'),
                'completed' => !is_null($this->approved_at) || !is_null($this->rejected_at),
                'date' => $this->approved_at ?? $this->rejected_at,
            ],
        ];
    }

    public function getDaysAgo(): string
    {
        $date = $this->submitted_at ?? $this->created_at;
        $days = $date->diffInDays(now());
        
        if ($days === 0) {
            return 'Today';
        } elseif ($days === 1) {
            return 'Yesterday';
        } else {
            return $days . ' days ago';
        }
    }
}