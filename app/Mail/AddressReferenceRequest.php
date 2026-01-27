<?php

namespace App\Mail;

use App\Models\UserAddress;
use App\Models\User;
use App\Models\PropertyApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AddressReferenceRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $address;
    public $applicant;
    public $application;
    public $verificationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(UserAddress $address, User $applicant, PropertyApplication $application)
    {
        $this->address = $address;
        $this->applicant = $applicant;
        $this->application = $application;
        $this->verificationUrl = route('address-reference.form', ['token' => $address->reference_token]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Address Reference Request - ' . $this->applicant->profile->first_name . ' ' . $this->applicant->profile->last_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.address-reference-request',
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