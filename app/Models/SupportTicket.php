<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'subject',
        'message',
        'category',
        'priority',
        'status',
        'user_type',
        'assigned_to',
        'resolved_at',
        'closed_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Generate unique ticket number
     */
    public static function generateTicketNumber()
    {
        do {
            $number = 'TKT-' . strtoupper(substr(uniqid(), -8));
        } while (self::where('ticket_number', $number)->exists());
        
        return $number;
    }

    /**
     * Get the user who created the ticket
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get assigned staff member
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get ticket replies
     */
    public function replies()
    {
        return $this->hasMany(SupportTicketReply::class, 'ticket_id');
    }

    /**
     * Get ticket attachments
     */
    public function attachments()
    {
        return $this->hasMany(SupportTicketAttachment::class, 'ticket_id');
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'open' => 'bg-blue-100 text-blue-800',
            'in_progress' => 'bg-yellow-100 text-yellow-800',
            'waiting_response' => 'bg-purple-100 text-purple-800',
            'resolved' => 'bg-green-100 text-green-800',
            'closed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get priority badge color
     */
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'urgent' => 'bg-red-100 text-red-800',
            'high' => 'bg-orange-100 text-orange-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'low' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}