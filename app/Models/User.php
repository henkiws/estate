<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'position',
        'agency_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the agency that owns the user.
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Get the agency contact record for this user.
     */
    public function agencyContact()
    {
        return $this->hasOne(AgencyContact::class);
    }

    /**
     * Get the agent profile for this user.
     */
    public function agentProfile()
    {
        return $this->hasOne(Agent::class);
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is an agency
     */
    public function isAgency(): bool
    {
        return $this->hasRole('agency');
    }

    /**
     * Check if user is an agent
     */
    public function isAgent(): bool
    {
        return $this->hasRole('agent');
    }

    /**
     * Get user's full role name
     */
    public function getRoleName(): string
    {
        return $this->roles->first()?->name ?? 'unknown';
    }

    /**
     * Check if user belongs to an agency
     */
    public function belongsToAgency(): bool
    {
        return !is_null($this->agency_id);
    }

    /**
     * Get full phone number with format
     */
    public function getFormattedPhone(): ?string
    {
        return $this->phone ? preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2 $3', $this->phone) : null;
    }
}