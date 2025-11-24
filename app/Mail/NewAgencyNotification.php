<?php

namespace App\Mail;

use App\Models\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewAgencyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Agency $agency
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Agency Registration - Action Required',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.new-agency',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}