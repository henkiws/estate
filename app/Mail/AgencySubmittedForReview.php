<?php

namespace App\Mail;

use App\Models\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgencySubmittedForReview extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Agency $agency;
    public int $documentsUploaded;

    /**
     * Create a new message instance.
     */
    public function __construct(Agency $agency, int $documentsUploaded)
    {
        $this->agency = $agency;
        $this->documentsUploaded = $documentsUploaded;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Agency Submitted for Review - ' . $this->agency->agency_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.agency-submitted',
            with: [
                'agency' => $this->agency,
                'documentsUploaded' => $this->documentsUploaded,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}