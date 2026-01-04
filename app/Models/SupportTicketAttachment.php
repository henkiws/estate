<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicketAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'reply_id',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    /**
     * Get the ticket this attachment belongs to
     */
    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }

    /**
     * Get the reply this attachment belongs to
     */
    public function reply()
    {
        return $this->belongsTo(SupportTicketReply::class, 'reply_id');
    }
}