<?php

namespace App\Mail;

use App\Models\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgencyRejected extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Agency $agency;
    public string $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(Agency $agency)
    {
        $this->agency = $agency;
        $this->reason = $agency->rejection_reason ?? 'No reason provided';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Agency Registration Update - ' . $this->agency->agency_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.agency.rejected',
            with: [
                'agency' => $this->agency,
                'reason' => $this->reason,
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