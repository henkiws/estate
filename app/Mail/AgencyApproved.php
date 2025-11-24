<?php

namespace App\Mail;

use App\Models\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgencyApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Agency $agency
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Agency Has Been Approved - Sorted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.agency.approved',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}