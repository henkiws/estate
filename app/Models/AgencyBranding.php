<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyBranding extends Model
{
    use HasFactory;

    protected $table = 'agency_brandings';

    protected $fillable = [
        'agency_id',
        'logo_path',
        'brand_color',
        'description',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'twitter_url',
        'office_hours',
    ];

    protected $casts = [
        'office_hours' => 'array',
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function hasLogo(): bool
    {
        return !empty($this->logo_path);
    }

    public function hasSocialMedia(): bool
    {
        return !empty($this->facebook_url) || !empty($this->instagram_url) || 
               !empty($this->linkedin_url) || !empty($this->twitter_url);
    }
}