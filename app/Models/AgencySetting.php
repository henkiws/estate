<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'settings',
        'terms_accepted',
        'terms_accepted_at',
        'terms_accepted_ip',
        'privacy_accepted',
        'privacy_accepted_at',
        'privacy_accepted_ip',
    ];

    protected $casts = [
        'settings' => 'array',
        'terms_accepted' => 'boolean',
        'privacy_accepted' => 'boolean',
        'terms_accepted_at' => 'datetime',
        'privacy_accepted_at' => 'datetime',
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function hasAcceptedTerms(): bool
    {
        return $this->terms_accepted && $this->privacy_accepted;
    }
}