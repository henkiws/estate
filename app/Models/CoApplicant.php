<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoApplicant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'application_co_applicants';

    protected $fillable = [
        'property_application_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'relationship_to_applicant',
        'employment_status',
        'employer_name',
        'annual_income',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'annual_income' => 'decimal:2',
    ];

    /**
     * Get the application this co-applicant belongs to
     */
    public function application()
    {
        return $this->belongsTo(PropertyApplication::class, 'property_application_id');
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get initials for avatar
     */
    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }
}