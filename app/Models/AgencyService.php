<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyService extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'service_areas',
        'residential',
        'commercial',
        'rentals',
        'sales',
        'rural',
        'industrial',
        'number_of_agents',
        'number_of_employees',
    ];

    protected $casts = [
        'service_areas' => 'array',
        'residential' => 'boolean',
        'commercial' => 'boolean',
        'rentals' => 'boolean',
        'sales' => 'boolean',
        'rural' => 'boolean',
        'industrial' => 'boolean',
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function getPropertyTypes(): array
    {
        $types = [];
        if ($this->residential) $types[] = 'Residential';
        if ($this->commercial) $types[] = 'Commercial';
        if ($this->rentals) $types[] = 'Rentals';
        if ($this->sales) $types[] = 'Sales';
        if ($this->rural) $types[] = 'Rural';
        if ($this->industrial) $types[] = 'Industrial';
        return $types;
    }
}