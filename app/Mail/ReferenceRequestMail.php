<?php

namespace App\Mail;

use App\Models\User;
use App\Models\UserReference;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ReferenceRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reference;
    public $referenceUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, UserReference $reference)
    {
        $this->user = $user;
        $this->reference = $reference;
        
        // Generate a secure token for the reference to respond
        $token = $this->generateReferenceToken($reference);
        $this->referenceUrl = route('reference.form', ['token' => $token]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'Reference Request for ' . $this->user->name . ' - Plyform Rental Application',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reference-request',
            with: [
                'userName' => $this->user->name,
                'referenceName' => $this->reference->full_name,
                'relationship' => $this->reference->relationship,
                'referenceUrl' => $this->referenceUrl,
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

    /**
     * Generate a secure token for the reference
     */
    private function generateReferenceToken(UserReference $reference): string
    {
        // Create a secure token and store it
        $token = bin2hex(random_bytes(32));
        
        // Store token in database (you'll need to add this column)
        $reference->update([
            'reference_token' => hash('sha256', $token),
            'token_expires_at' => now()->addDays(14), // Token valid for 14 days
        ]);
        
        return $token;
    }
}