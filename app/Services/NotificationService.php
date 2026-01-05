<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
    /**
     * Create a broadcast notification for multiple users
     */
    public function broadcast(array $data, array $recipientIds, bool $schedule = false)
    {
        $notifications = [];
        $sentAt = $schedule ? null : now();
        $scheduledFor = $schedule ? ($data['scheduled_for'] ?? null) : null;

        foreach ($recipientIds as $recipientId) {
            $notifications[] = [
                'title' => $data['title'],
                'message' => $data['message'],
                'type' => 'broadcast',
                'category' => $data['category'] ?? 'general',
                'priority' => $data['priority'] ?? 'medium',
                'sender_id' => $data['sender_id'] ?? auth()->id(),
                'recipient_id' => $recipientId,
                'action_url' => $data['action_url'] ?? null,
                'action_text' => $data['action_text'] ?? null,
                'icon' => $data['icon'] ?? null,
                'metadata' => $data['metadata'] ?? null,
                'sent_at' => $sentAt,
                'scheduled_for' => $scheduledFor,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Notification::insert($notifications);

        return count($notifications);
    }

    /**
     * Create a system notification
     */
    public function system(array $data)
    {
        return Notification::create([
            'title' => $data['title'],
            'message' => $data['message'],
            'type' => 'system',
            'category' => $data['category'] ?? 'general',
            'priority' => $data['priority'] ?? 'medium',
            'sender_id' => null, // System notifications have no sender
            'recipient_id' => $data['recipient_id'],
            'action_url' => $data['action_url'] ?? null,
            'action_text' => $data['action_text'] ?? null,
            'icon' => $data['icon'] ?? null,
            'metadata' => $data['metadata'] ?? null,
            'sent_at' => now(),
        ]);
    }

    /**
     * Notify when agency is approved
     */
    public function agencyApproved($agency)
    {
        $users = $agency->users; // All users in the agency

        foreach ($users as $user) {
            $this->system([
                'title' => 'Agency Approved!',
                'message' => "Congratulations! Your agency '{$agency->agency_name}' has been approved. You can now choose a subscription plan.",
                'category' => 'approval',
                'priority' => 'high',
                'recipient_id' => $user->id,
                'action_url' => route('agency.subscription.plans'),
                'action_text' => 'Choose Plan',
                'metadata' => [
                    'agency_id' => $agency->id,
                    'agency_name' => $agency->agency_name,
                ],
            ]);
        }
    }

    /**
     * Notify when agency is rejected
     */
    public function agencyRejected($agency, $reason)
    {
        $users = $agency->users;

        foreach ($users as $user) {
            $this->system([
                'title' => 'Agency Application Rejected',
                'message' => "Unfortunately, your agency application has been rejected. Reason: {$reason}",
                'category' => 'approval',
                'priority' => 'high',
                'recipient_id' => $user->id,
                'action_url' => route('agency.dashboard'),
                'action_text' => 'View Dashboard',
                'metadata' => [
                    'agency_id' => $agency->id,
                    'reason' => $reason,
                ],
            ]);
        }
    }

    /**
     * Notify when document is approved
     */
    public function documentApproved($document, $agency)
    {
        $users = $agency->users;

        foreach ($users as $user) {
            $this->system([
                'title' => 'Document Approved',
                'message' => "Your document '{$document->name}' has been approved by the admin.",
                'category' => 'document',
                'priority' => 'medium',
                'recipient_id' => $user->id,
                'action_url' => route('agency.documents.index'),
                'action_text' => 'View Documents',
                'metadata' => [
                    'document_id' => $document->id,
                    'document_name' => $document->name,
                ],
            ]);
        }
    }

    /**
     * Notify when document is rejected
     */
    public function documentRejected($document, $agency, $reason)
    {
        $users = $agency->users;

        foreach ($users as $user) {
            $this->system([
                'title' => 'Document Rejected',
                'message' => "Your document '{$document->name}' was rejected. Reason: {$reason}",
                'category' => 'document',
                'priority' => 'high',
                'recipient_id' => $user->id,
                'action_url' => route('agency.documents.index'),
                'action_text' => 'View Documents',
                'metadata' => [
                    'document_id' => $document->id,
                    'document_name' => $document->name,
                    'reason' => $reason,
                ],
            ]);
        }
    }

    /**
     * Notify when payment is received
     */
    public function paymentReceived($transaction, $user)
    {
        $this->system([
            'title' => 'Payment Received',
            'message' => "Your payment of \${$transaction->formatted_amount} has been successfully processed.",
            'category' => 'payment',
            'priority' => 'medium',
            'recipient_id' => $user->id,
            'action_url' => route('agency.payments.show', $transaction->id),
            'action_text' => 'View Receipt',
            'metadata' => [
                'transaction_id' => $transaction->id,
                'amount' => $transaction->amount,
            ],
        ]);
    }

    /**
     * Notify when subscription is expiring soon
     */
    public function subscriptionExpiringSoon($subscription, $daysLeft)
    {
        $users = $subscription->agency->users;

        foreach ($users as $user) {
            $this->system([
                'title' => 'Subscription Expiring Soon',
                'message' => "Your subscription will expire in {$daysLeft} days. Please renew to continue using our services.",
                'category' => 'subscription',
                'priority' => 'high',
                'recipient_id' => $user->id,
                'action_url' => route('agency.subscription.index'),
                'action_text' => 'Renew Now',
                'metadata' => [
                    'subscription_id' => $subscription->id,
                    'days_left' => $daysLeft,
                    'expires_at' => $subscription->current_period_end->toDateString(),
                ],
            ]);
        }
    }

    /**
     * Notify when support ticket receives a reply
     */
    public function supportTicketReplied($ticket, $reply)
    {
        $this->system([
            'title' => 'Support Ticket Reply',
            'message' => "Your support ticket #{$ticket->ticket_number} has received a new reply.",
            'category' => 'support',
            'priority' => 'medium',
            'recipient_id' => $ticket->user_id,
            'action_url' => route('user.support.show', $ticket->id),
            'action_text' => 'View Ticket',
            'metadata' => [
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
            ],
        ]);
    }

    /**
     * Get all recipients based on target type
     */
    public function getRecipientIds(string $targetType, ?array $specificIds = null): array
    {
        if ($specificIds) {
            return $specificIds;
        }

        return match($targetType) {
            'all_users' => User::where('role', 'user')->pluck('id')->toArray(),
            'all_agencies' => User::where('role', 'agency')->pluck('id')->toArray(),
            'all_agents' => User::where('role', 'agent')->pluck('id')->toArray(),
            'all' => User::pluck('id')->toArray(),
            default => [],
        };
    }

    /**
     * Get unread count for a user
     */
    public function getUnreadCount($userId): int
    {
        return Notification::forUser($userId)
            ->unread()
            ->sent()
            ->count();
    }

    /**
     * Get recent notifications for a user
     */
    public function getRecent($userId, int $limit = 10): Collection
    {
        return Notification::forUser($userId)
            ->sent()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Mark all as read for a user
     */
    public function markAllAsRead($userId): int
    {
        return Notification::forUser($userId)
            ->unread()
            ->update(['read_at' => now()]);
    }

    /**
     * Process scheduled notifications (run via cron)
     */
    public function processScheduled()
    {
        $notifications = Notification::scheduled()
            ->where('scheduled_for', '<=', now())
            ->get();

        foreach ($notifications as $notification) {
            $notification->markAsSent();
        }

        return $notifications->count();
    }
}