<?php

namespace App\Mail;

use App\Models\UserAddress;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AddressReferenceThankYou extends Mailable
{
    use Queueable, SerializesModels;

    public $address;

    public function __construct(UserAddress $address)
    {
        $this->address = $address;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank You - Reference Submitted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.address-reference-thank-you',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}