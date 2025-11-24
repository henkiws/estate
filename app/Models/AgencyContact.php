<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'user_id',
        'full_name',
        'position',
        'email',
        'phone',
        'mobile',
        'is_primary',
        'id_verification_type',
        'id_verification_number',
        'id_verification_file',
        'id_verification_expiry',
        'wwcc_number',
        'wwcc_expiry',
        'wwcc_file',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'id_verification_expiry' => 'date',
        'wwcc_expiry' => 'date',
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hasValidWWCC(): bool
    {
        return $this->wwcc_number && $this->wwcc_expiry && $this->wwcc_expiry->isFuture();
    }

    public function hasValidID(): bool
    {
        return $this->id_verification_number && $this->id_verification_expiry && $this->id_verification_expiry->isFuture();
    }
}