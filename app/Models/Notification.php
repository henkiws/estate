<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'message',
        'type',
        'category',
        'priority',
        'sender_id',
        'recipient_id',
        'action_url',
        'action_text',
        'icon',
        'metadata',
        'read_at',
        'sent_at',
        'scheduled_for',
    ];

    protected $casts = [
        'metadata' => 'array',
        'read_at' => 'datetime',
        'sent_at' => 'datetime',
        'scheduled_for' => 'datetime',
    ];

    protected $appends = ['time_ago'];

    /**
     * Relationships
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Scopes
     */
    public function scopeUnread(Builder $query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead(Builder $query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopeForUser(Builder $query, $userId)
    {
        return $query->where('recipient_id', $userId);
    }

    public function scopePriority(Builder $query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeCategory(Builder $query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSent(Builder $query)
    {
        return $query->whereNotNull('sent_at')
                    ->where(function($q) {
                        $q->whereNull('scheduled_for')
                          ->orWhere('scheduled_for', '<=', now());
                    });
    }

    public function scopeScheduled(Builder $query)
    {
        return $query->whereNotNull('scheduled_for')
                    ->where('scheduled_for', '>', now())
                    ->whereNull('sent_at');
    }

    public function scopePending(Builder $query)
    {
        return $query->whereNull('sent_at')
                    ->whereNull('scheduled_for');
    }

    /**
     * Helper Methods
     */
    public function markAsRead()
    {
        if ($this->read_at === null) {
            $this->update(['read_at' => now()]);
        }
    }

    public function markAsUnread()
    {
        $this->update(['read_at' => null]);
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function isUnread(): bool
    {
        return $this->read_at === null;
    }

    public function isScheduled(): bool
    {
        return $this->scheduled_for !== null && $this->scheduled_for->isFuture();
    }

    public function isSent(): bool
    {
        return $this->sent_at !== null;
    }

    public function markAsSent()
    {
        if ($this->sent_at === null) {
            $this->update(['sent_at' => now()]);
        }
    }

    /**
     * Get priority color for UI
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'high' => 'bg-red-100 text-red-800 border-red-200',
            'medium' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'low' => 'bg-green-100 text-green-800 border-green-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    /**
     * Get category icon
     */
    public function getCategoryIconAttribute(): string
    {
        return match($this->category) {
            'payment' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
            'approval' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'document' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
            'support' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'subscription' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
            'maintenance' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
            default => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9',
        };
    }

    /**
     * Get time ago formatted
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}