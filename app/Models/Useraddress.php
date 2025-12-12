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
        'address',
        'years_lived',
        'months_lived',
        'reason_for_leaving',
        'different_postal_address',
        'postal_code',
        'is_current',
    ];

    protected $casts = [
        'years_lived' => 'integer',
        'months_lived' => 'integer',
        'different_postal_address' => 'boolean',
        'is_current' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalMonthsAttribute(): int
    {
        return ($this->years_lived * 12) + $this->months_lived;
    }
}