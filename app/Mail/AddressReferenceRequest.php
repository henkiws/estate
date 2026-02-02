<?php

namespace App\Mail;

use App\Models\UserAddress;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AddressReferenceRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $address;
    public $user;
    public $referenceUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(UserAddress $address)
    {
        $this->address = $address;
        $this->user = $address->user; // Get user from address relationship
        
        // ✅ FIX: Use the correct route name that exists
        $this->referenceUrl = route('address-reference.form', ['token' => $address->reference_token]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $userName = $this->user->profile 
            ? $this->user->profile->first_name . ' ' . $this->user->profile->last_name 
            : $this->user->name;
            
        return new Envelope(
            subject: 'Address Reference Request - ' . $userName,
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