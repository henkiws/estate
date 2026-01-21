<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'relationship',
        'mobile_country_code',
        'mobile_number',
        'email',
        'reference_token',
        'token_expires_at',
        'reference_submitted_at',
        'reference_response',
        'reference_status',
    ];

    protected $casts = [
        'token_expires_at' => 'datetime',
        'reference_submitted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the reference token is still valid
     */
    public function isTokenValid(): bool
    {
        return $this->token_expires_at && 
               $this->token_expires_at->isFuture() && 
               $this->reference_status === 'pending';
    }
}