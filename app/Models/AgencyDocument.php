<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'document_type',
        'document_name',
        'file_path',
        'file_type',
        'file_size',
        'status',
        'rejection_reason',
        'verified_at',
        'verified_by',
        'expiry_date',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'expiry_date' => 'date',
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function getFileSizeInMB(): float
    {
        return round($this->file_size / 1024 / 1024, 2);
    }
}