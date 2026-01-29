<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEmployment extends Model
{
    use HasFactory;

    protected $fillable = [
         'user_id',
        'company_name',
        'address',
        'position',
        'manager_full_name',
        'contact_country_code',
        'contact_number',
        'email',
        'start_date',
        'still_employed',
        'end_date',
        'employment_letter_path',
        'reference_token',
        'reference_status',
        'reference_email_sent_at',
        'reference_verified_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'still_employed' => 'boolean',
        'reference_email_sent_at' => 'datetime',  // ✅ ADD THIS
        'reference_verified_at' => 'datetime',
    ];

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reference(): HasOne
    {
        return $this->hasOne(UserEmploymentReference::class, 'user_employment_id');
    }

    /**
     * Check if reference is verified
     */
    public function isReferenceVerified(): bool
    {
        return $this->reference_status === 'verified';
    }

    /**
     * Check if reference is pending
     */
    public function isReferencePending(): bool
    {
        return $this->reference_status === 'pending';
    }
}