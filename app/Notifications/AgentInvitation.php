<?php

namespace App\Notifications;

use App\Models\Agent;
use App\Models\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class AgentInvitation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $agent;
    protected $agency;

    public function __construct(Agent $agent, Agency $agency)
    {
        $this->agent = $agent;
        $this->agency = $agency;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $setPasswordUrl = URL::temporarySignedRoute(
            'password.reset',
            now()->addDays(7),
            ['token' => app('auth.password.broker')->createToken($notifiable)]
        );

        return (new MailMessage)
            ->subject("Welcome to {$this->agency->agency_name}!")
            ->greeting("Hi {$this->agent->first_name}!")
            ->line("You've been added as an agent to **{$this->agency->agency_name}**.")
            ->line("We're excited to have you on board! Your account has been created and you can now access our platform.")
            ->line("**Your Details:**")
            ->line("- Agent Code: {$this->agent->agent_code}")
            ->line("- Position: " . ($this->agent->position ?? 'Agent'))
            ->line("- Email: {$this->agent->email}")
            ->action('Set Your Password & Login', $setPasswordUrl)
            ->line("This link will expire in 7 days for security purposes.")
            ->line("Once you've set your password, you'll have full access to:")
            ->line("- Manage your properties and listings")
            ->line("- Access client information")
            ->line("- Update your profile")
            ->line("- Communicate with the team")
            ->line("If you have any questions, please don't hesitate to reach out to your agency.")
            ->salutation("Best regards,\nThe {$this->agency->agency_name} Team");
    }
}