<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ApplicationDraft extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'property_address',
        'property_code',
        'form_data',
        'current_step',
        'total_steps',
        'status',
        'last_edited_at',
        'expires_at',
    ];

    protected $casts = [
        'form_data' => 'array',
        'last_edited_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Set expiry date on creation (30 days from now)
        static::creating(function ($draft) {
            if (!$draft->expires_at) {
                $draft->expires_at = now()->addDays(30);
            }
        });

        // Update last_edited_at on save
        static::saving(function ($draft) {
            $draft->last_edited_at = now();
        });
    }

    /**
     * Get the user that owns the draft
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property associated with the draft
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get progress percentage
     */
    public function getProgressPercentageAttribute()
    {
        return round(($this->current_step / $this->total_steps) * 100);
    }

    /**
     * Get display address
     */
    public function getDisplayAddressAttribute()
    {
        if ($this->property) {
            return $this->property->short_address;
        }
        
        return $this->property_address ?? 'Untitled Property';
    }

    /**
     * Get time since last edit (human readable)
     */
    public function getLastEditedHumanAttribute()
    {
        return $this->last_edited_at->diffForHumans();
    }

    /**
     * Check if draft is expired
     */
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Scope to get active drafts
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'draft')
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Scope to get user's drafts
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get expired drafts
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    /**
     * Mark as converted to application
     */
    public function markAsConverted()
    {
        $this->update(['status' => 'converted']);
    }

    /**
     * Mark as abandoned
     */
    public function markAsAbandoned()
    {
        $this->update(['status' => 'abandoned']);
    }
}