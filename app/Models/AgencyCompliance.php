<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyCompliance extends Model
{
    use HasFactory;

    protected $table = 'agency_compliances';

    protected $fillable = [
        'agency_id',
        'trust_account_bsb',
        'trust_account_number',
        'trust_account_name',
        'trust_account_bank',
        'professional_indemnity_provider',
        'professional_indemnity_policy_number',
        'professional_indemnity_expiry',
        'public_liability_provider',
        'public_liability_policy_number',
        'public_liability_expiry',
    ];

    protected $casts = [
        'professional_indemnity_expiry' => 'date',
        'public_liability_expiry' => 'date',
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function hasTrustAccount(): bool
    {
        return !empty($this->trust_account_bsb) && !empty($this->trust_account_number);
    }

    public function hasValidInsurance(): bool
    {
        $piValid = $this->professional_indemnity_expiry && $this->professional_indemnity_expiry->isFuture();
        $plValid = $this->public_liability_expiry && $this->public_liability_expiry->isFuture();
        return $piValid && $plValid;
    }
}