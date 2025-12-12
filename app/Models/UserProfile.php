<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'submitted_at',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'surname',
        'date_of_birth',
        'email',
        'mobile_country_code',
        'mobile_number',
        'emergency_contact_name',
        'emergency_contact_relationship',
        'emergency_contact_country_code',
        'emergency_contact_number',
        'emergency_contact_email',
        'has_guarantor',
        'guarantor_name',
        'guarantor_country_code',
        'guarantor_number',
        'guarantor_email',
        'introduction',
        'terms_accepted',
        'signature',
        'terms_accepted_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'has_guarantor' => 'boolean',
        'terms_accepted' => 'boolean',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'terms_accepted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function incomes(): HasMany
    {
        return $this->hasMany(UserIncome::class, 'user_id', 'user_id');
    }

    public function employments(): HasMany
    {
        return $this->hasMany(UserEmployment::class, 'user_id', 'user_id');
    }

    public function pets(): HasMany
    {
        return $this->hasMany(UserPet::class, 'user_id', 'user_id');
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(UserVehicle::class, 'user_id', 'user_id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class, 'user_id', 'user_id');
    }

    public function references(): HasMany
    {
        return $this->hasMany(UserReference::class, 'user_id', 'user_id');
    }

    public function identifications(): HasMany
    {
        return $this->hasMany(UserIdentification::class, 'user_id', 'user_id');
    }

    public function getTotalIdPointsAttribute(): int
    {
        return $this->identifications()->sum('points');
    }

    public function hasMinimumIdPoints(): bool
    {
        return $this->total_id_points >= 80;
    }

    public function isComplete(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}