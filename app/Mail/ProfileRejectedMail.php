<?php

namespace App\Mail;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProfileRejectedMail extends Mailable
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
            subject: '⚠️ Profile Update Required - Sorted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.profile-rejected',
            with: [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'rejectionReason' => $this->profile->rejection_reason,
                'rejectedAt' => $this->profile->rejected_at,
                'updateProfileUrl' => route('user.profile.complete'),
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