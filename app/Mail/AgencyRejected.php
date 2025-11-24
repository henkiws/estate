<?php

namespace App\Mail;

use App\Models\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgencyRejected extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Agency $agency,
        public ?string $reason = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Agency Registration Update - Sorted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.agency.rejected',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}