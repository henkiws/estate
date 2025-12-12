<?php

namespace App\Mail;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProfileApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $profile;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, UserProfile $profile)
    {
        $this->user = $user;
        $this->profile = $profile;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Your Profile Has Been Approved - Sorted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.profile-approved',
            with: [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'approvedAt' => $this->profile->approved_at,
                'dashboardUrl' => route('user.dashboard'),
                'propertiesUrl' => route('properties.index'),
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