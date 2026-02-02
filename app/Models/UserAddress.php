<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'living_arrangement',
        'owned_property',
        'address',
        'years_lived',
        'months_lived',
        'reason_for_leaving',
        'different_postal_address',
        'postal_code',
        'is_current',
        // Reference fields
        'reference_full_name',
        'reference_email',
        'reference_country_code',
        'reference_phone',
        'reference_token',
        'reference_status',
        'reference_email_sent_at',
        'reference_verified_at',
        // Reference form data
        'ref_is_leaseholder',
        'ref_is_leaseholder_comment',
        'ref_would_rent_again',
        'ref_would_rent_again_comment',
        'ref_lived_at_address',
        'ref_lived_at_address_comment',
        'ref_rent_paid_on_time',
        'ref_rent_paid_on_time_comment',
        'ref_last_inspection_month',
        'ref_last_inspection_year',
        'ref_last_inspection_comment',
        'ref_rent_per_week',
        'ref_rent_per_week_comment',
        'ref_full_bond_refund',
        'ref_full_bond_refund_comment',
        'ref_breach_free',
        'ref_breach_free_comment',
        'ref_property_clean',
        'ref_property_clean_comment',
        'ref_had_pet',
        'ref_had_pet_comment',
        'ref_pet_policy_complied',
        'ref_pet_policy_complied_comment',
        'ref_cooperative_rating',
        'ref_cooperative_rating_comment',
        'ref_property_condition_rating',
        'ref_property_condition_rating_comment',
        'ref_overall_rating',
        'ref_overall_rating_comment',
        'ref_tenant_ledger_path',
        'ref_is_draft',
        'ref_saved_as_draft_at',
        'ref_submitted_at',
        'ref_signature_name',
        'ref_signature_date',
    ];

    protected $casts = [
        'years_lived' => 'integer',
        'months_lived' => 'integer',
        'different_postal_address' => 'boolean',
        'is_current' => 'boolean',
        'owned_property' => 'boolean',
        'reference_verified' => 'boolean',
        'reference_verified_at' => 'datetime',
        'reference_email_sent_at' => 'datetime',
        'ref_is_draft' => 'boolean',
        'ref_saved_as_draft_at' => 'datetime',
        'ref_submitted_at' => 'datetime',
        'ref_rent_per_week' => 'decimal:2',
        'ref_overall_rating' => 'integer',
        'ref_signature_date' => 'date',
        'ref_cooperative_rating' => 'integer',
        'ref_property_condition_rating' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalMonthsAttribute(): int
    {
        return ($this->years_lived * 12) + $this->months_lived;
    }

    public function referenceEmailSent(): bool
    {
        return !is_null($this->reference_email_sent_at);
    }

    public function referenceSubmitted(): bool
    {
        return !is_null($this->ref_submitted_at);
    }

    public function referenceSavedAsDraft(): bool
    {
        return $this->ref_is_draft;
    }

    public function generateReferenceToken(): string
    {
        $this->reference_token = \Str::random(64);
        $this->save();
        return $this->reference_token;
    }

    public function addressReference(): HasOne
    {
        return $this->hasOne(UserAddressReference::class, 'user_address_id');
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

    /**
     * Check if this address needs a reference
     */
    public function needsReference(): bool
    {
        return !$this->owned_property && !empty($this->reference_email);
    }
}