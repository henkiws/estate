<?php

namespace App\Mail;

use App\Models\UserEmployment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmploymentReferenceRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $employment;
    public $user;
    public $referenceUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(UserEmployment $employment)
    {
        $this->employment = $employment;
        $this->user = $employment->user;
        $this->referenceUrl = route('employment.reference.form', ['token' => $employment->reference_token]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Employment Reference Request for ' . $this->user->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.employment-reference-request',
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