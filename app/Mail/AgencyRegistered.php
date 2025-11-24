<?php

namespace App\Mail;

use App\Models\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// ============================================
// 1. Agency Registered Notification
// ============================================
class AgencyRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Agency $agency
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Sorted - Agency Registration Received',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.agency.registered',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}