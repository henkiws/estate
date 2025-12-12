<?php

namespace App\Mail;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProfileSubmittedNotification extends Mailable
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
            subject: 'New Profile Submitted for Approval - ' . $this->user->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.profile-submitted',
            with: [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'submittedAt' => $this->profile->submitted_at,
                'profileUrl' => route('admin.profiles.show', $this->profile->id),
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