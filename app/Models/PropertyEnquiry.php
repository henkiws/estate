<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyEnquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'agency_id',
        'name',
        'email',
        'phone',
        'message',
        'status',
        'agency_reply',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who made the enquiry
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property being enquired about
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the agency managing the property
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'new' => 'blue',
            'replied' => 'green',
            'closed' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Scope to get new enquiries
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope to get enquiries for a specific agency
     */
    public function scopeForAgency($query, $agencyId)
    {
        return $query->where('agency_id', $agencyId);
    }

    /**
     * Mark enquiry as replied
     */
    public function markAsReplied($reply = null)
    {
        $this->update([
            'status' => 'replied',
            'agency_reply' => $reply,
            'replied_at' => now(),
        ]);
    }
}