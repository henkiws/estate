<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_code',
        'user_id',
        'property_id',
        'agency_id',
        'application_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'lease_start_date',
        'lease_end_date',
        'lease_term_months',
        'rent_amount',
        'payment_frequency',
        'next_payment_due',
        'bond_amount',
        'bond_paid',
        'bond_paid_date',
        'bond_reference',
        'status',
        'notice_given_date',
        'intended_vacate_date',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'additional_occupants',
        'moved_in_at',
        'moved_out_at',
        'lease_signed_at',
        'notes',
        'documents',
        'metadata',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'lease_start_date' => 'date',
        'lease_end_date' => 'date',
        'next_payment_due' => 'date',
        'bond_paid_date' => 'date',
        'notice_given_date' => 'date',
        'intended_vacate_date' => 'date',
        'moved_in_at' => 'date',
        'moved_out_at' => 'date',
        'lease_signed_at' => 'datetime',
        'bond_paid' => 'boolean',
        'rent_amount' => 'decimal:2',
        'bond_amount' => 'decimal:2',
        'additional_occupants' => 'array',
        'documents' => 'array',
        'metadata' => 'array',
    ];

    protected $appends = [
        'full_name',
        'status_color',
        'days_until_lease_end',
        'is_lease_expiring_soon',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tenant) {
            // Generate tenant code if not set
            if (empty($tenant->tenant_code)) {
                $tenant->tenant_code = 'TNT-' . strtoupper(Str::random(8));
            }

            // Set next payment due based on lease start and frequency
            if ($tenant->lease_start_date && !$tenant->next_payment_due) {
                $tenant->next_payment_due = $tenant->calculateNextPaymentDue($tenant->lease_start_date);
            }
        });
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function application()
    {
        return $this->belongsTo(PropertyApplication::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePendingMoveIn($query)
    {
        return $query->where('status', 'pending_move_in');
    }

    public function scopeNoticeGiven($query)
    {
        return $query->where('status', 'notice_given');
    }

    public function scopeEnding($query)
    {
        return $query->where('status', 'ending');
    }

    public function scopeEnded($query)
    {
        return $query->where('status', 'ended');
    }

    public function scopeExpiringWithin($query, $days = 30)
    {
        return $query->whereDate('lease_end_date', '<=', now()->addDays($days))
                     ->whereDate('lease_end_date', '>=', now());
    }

    /**
     * Accessors
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending_move_in' => 'bg-yellow-100 text-yellow-700',
            'active' => 'bg-green-100 text-green-700',
            'notice_given' => 'bg-orange-100 text-orange-700',
            'ending' => 'bg-red-100 text-red-700',
            'ended' => 'bg-gray-100 text-gray-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending_move_in' => 'Pending Move-In',
            'active' => 'Active',
            'notice_given' => 'Notice Given',
            'ending' => 'Ending Soon',
            'ended' => 'Ended',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getDaysUntilLeaseEndAttribute()
    {
        if (!$this->lease_end_date) {
            return null;
        }

        return now()->diffInDays($this->lease_end_date, false);
    }

    public function getIsLeaseExpiringSoonAttribute()
    {
        $daysUntilEnd = $this->days_until_lease_end;
        
        return $daysUntilEnd !== null && $daysUntilEnd >= 0 && $daysUntilEnd <= 60;
    }

    public function getFormattedRentAttribute()
    {
        $amount = '$' . number_format($this->rent_amount, 0);
        
        return match($this->payment_frequency) {
            'weekly' => "{$amount} per week",
            'fortnightly' => "{$amount} per fortnight",
            'monthly' => "{$amount} per month",
            default => $amount,
        };
    }

    /**
     * Methods
     */
    
    /**
     * Calculate next payment due date based on frequency
     */
    public function calculateNextPaymentDue($fromDate)
    {
        $date = \Carbon\Carbon::parse($fromDate);
        
        return match($this->payment_frequency) {
            'weekly' => $date->addWeek(),
            'fortnightly' => $date->addWeeks(2),
            'monthly' => $date->addMonth(),
            default => $date->addMonth(),
        };
    }

    /**
     * Update next payment due date
     */
    public function updateNextPaymentDue()
    {
        if (!$this->next_payment_due) {
            $this->next_payment_due = $this->calculateNextPaymentDue($this->lease_start_date);
        } else {
            $this->next_payment_due = $this->calculateNextPaymentDue($this->next_payment_due);
        }
        
        $this->save();
    }

    /**
     * Mark tenant as moved in
     */
    public function markAsMovedIn()
    {
        $this->update([
            'status' => 'active',
            'moved_in_at' => now(),
        ]);
    }

    /**
     * Mark tenant as moved out
     */
    public function markAsMovedOut()
    {
        $this->update([
            'status' => 'ended',
            'moved_out_at' => now(),
        ]);
    }

    /**
     * Record notice given
     */
    public function giveNotice($intendedVacateDate)
    {
        $this->update([
            'status' => 'notice_given',
            'notice_given_date' => now(),
            'intended_vacate_date' => $intendedVacateDate,
        ]);
    }

    /**
     * Check if tenant is overdue on rent
     */
    public function isRentOverdue()
    {
        return $this->next_payment_due && $this->next_payment_due->isPast();
    }

    /**
     * Get days overdue
     */
    public function getDaysOverdueAttribute()
    {
        if (!$this->isRentOverdue()) {
            return 0;
        }

        return now()->diffInDays($this->next_payment_due);
    }
}