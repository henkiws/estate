<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting notification seeding...');

        // Get users by role using Spatie Permission
        $users = User::role('user')->limit(10)->get();
        $agencies = User::role('agency')->limit(10)->get();
        $agents = User::role('agent')->limit(10)->get();
        $admins = User::role('admin')->get();

        $allUsers = $users->merge($agencies)->merge($agents);

        if ($allUsers->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        $admin = $admins->first();

        // Notification templates with different categories, priorities, and scenarios
        $templates = [
            // Payment notifications
            [
                'type' => 'system',
                'category' => 'payment',
                'priority' => 'medium',
                'title' => 'Payment Received',
                'message' => 'Your payment of $1,500.00 has been successfully processed. Thank you for your prompt payment.',
                'action_url' => '/agency/payments',
                'action_text' => 'View Receipt',
            ],
            [
                'type' => 'system',
                'category' => 'payment',
                'priority' => 'high',
                'title' => 'Payment Failed',
                'message' => 'We were unable to process your payment. Please update your payment method to continue using our services.',
                'action_url' => '/agency/subscription',
                'action_text' => 'Update Payment',
            ],
            [
                'type' => 'broadcast',
                'category' => 'payment',
                'priority' => 'medium',
                'title' => 'New Payment Options Available',
                'message' => 'We now accept PayPal and Google Pay in addition to credit cards. Update your payment preferences in your account settings.',
                'action_url' => '/settings/billing',
                'action_text' => 'View Options',
            ],

            // Approval notifications
            [
                'type' => 'system',
                'category' => 'approval',
                'priority' => 'high',
                'title' => 'Agency Approved!',
                'message' => 'Congratulations! Your agency has been approved. You can now choose a subscription plan and start listing properties.',
                'action_url' => '/agency/subscription/plans',
                'action_text' => 'Choose Plan',
            ],
            [
                'type' => 'system',
                'category' => 'approval',
                'priority' => 'high',
                'title' => 'Application Under Review',
                'message' => 'Your agency application is currently under review. We will notify you once the review is complete. This typically takes 1-2 business days.',
                'action_url' => '/agency/dashboard',
                'action_text' => 'View Status',
            ],
            [
                'type' => 'system',
                'category' => 'approval',
                'priority' => 'high',
                'title' => 'Application Rejected',
                'message' => 'Unfortunately, we were unable to approve your agency application at this time. Please review our requirements and resubmit your application.',
                'action_url' => '/agency/dashboard',
                'action_text' => 'Learn More',
            ],

            // Document notifications
            [
                'type' => 'system',
                'category' => 'document',
                'priority' => 'medium',
                'title' => 'Document Approved',
                'message' => 'Your Business License document has been approved by our admin team. You are one step closer to completing your profile.',
                'action_url' => '/agency/documents',
                'action_text' => 'View Documents',
            ],
            [
                'type' => 'system',
                'category' => 'document',
                'priority' => 'high',
                'title' => 'Document Rejected',
                'message' => 'Your Insurance Certificate was rejected. Reason: Document is expired. Please upload a valid, current document.',
                'action_url' => '/agency/documents',
                'action_text' => 'Upload New',
            ],
            [
                'type' => 'system',
                'category' => 'document',
                'priority' => 'medium',
                'title' => 'Document Expiring Soon',
                'message' => 'Your Real Estate License will expire in 30 days. Please upload a renewed version to avoid service interruption.',
                'action_url' => '/agency/documents',
                'action_text' => 'Upload Document',
            ],
            [
                'type' => 'broadcast',
                'category' => 'document',
                'priority' => 'low',
                'title' => 'New Document Upload Feature',
                'message' => 'You can now upload documents directly from your mobile device using our new mobile app. Download it today!',
                'action_url' => '/downloads',
                'action_text' => 'Get the App',
            ],

            // Support notifications
            [
                'type' => 'system',
                'category' => 'support',
                'priority' => 'medium',
                'title' => 'Support Ticket Reply',
                'message' => 'Your support ticket #TKT-12345 has received a new reply from our support team. Click to view the response.',
                'action_url' => '/support/tickets/12345',
                'action_text' => 'View Reply',
            ],
            [
                'type' => 'system',
                'category' => 'support',
                'priority' => 'low',
                'title' => 'Ticket Resolved',
                'message' => 'Your support ticket #TKT-12345 has been marked as resolved. If you need further assistance, you can reopen the ticket.',
                'action_url' => '/support/tickets/12345',
                'action_text' => 'View Ticket',
            ],
            [
                'type' => 'broadcast',
                'category' => 'support',
                'priority' => 'low',
                'title' => 'Extended Support Hours',
                'message' => 'Good news! Our support team is now available 24/7 to assist you with any questions or issues you may have.',
                'action_url' => '/support',
                'action_text' => 'Contact Support',
            ],

            // Subscription notifications
            [
                'type' => 'system',
                'category' => 'subscription',
                'priority' => 'high',
                'title' => 'Subscription Expiring Soon',
                'message' => 'Your subscription will expire in 7 days. Renew now to continue enjoying uninterrupted access to all features.',
                'action_url' => '/agency/subscription',
                'action_text' => 'Renew Now',
            ],
            [
                'type' => 'system',
                'category' => 'subscription',
                'priority' => 'high',
                'title' => 'Subscription Expired',
                'message' => 'Your subscription has expired. Your listings have been deactivated. Please renew to reactivate your account.',
                'action_url' => '/agency/subscription',
                'action_text' => 'Renew Subscription',
            ],
            [
                'type' => 'system',
                'category' => 'subscription',
                'priority' => 'medium',
                'title' => 'Subscription Renewed',
                'message' => 'Thank you! Your subscription has been successfully renewed. Your account will remain active until next billing cycle.',
                'action_url' => '/agency/subscription',
                'action_text' => 'View Details',
            ],
            [
                'type' => 'broadcast',
                'category' => 'subscription',
                'priority' => 'medium',
                'title' => 'New Premium Plan Available',
                'message' => 'Upgrade to our new Premium plan and get unlimited properties, priority support, and advanced analytics at a special launch price!',
                'action_url' => '/agency/subscription/plans',
                'action_text' => 'View Plans',
            ],

            // Maintenance notifications
            [
                'type' => 'broadcast',
                'category' => 'maintenance',
                'priority' => 'high',
                'title' => 'Scheduled Maintenance',
                'message' => 'Our platform will undergo scheduled maintenance on Saturday, 2:00 AM - 6:00 AM. Services will be temporarily unavailable during this time.',
                'action_url' => null,
                'action_text' => null,
            ],
            [
                'type' => 'broadcast',
                'category' => 'maintenance',
                'priority' => 'medium',
                'title' => 'Maintenance Complete',
                'message' => 'Scheduled maintenance has been completed successfully. All services are now fully operational. Thank you for your patience!',
                'action_url' => null,
                'action_text' => null,
            ],
            [
                'type' => 'broadcast',
                'category' => 'maintenance',
                'priority' => 'high',
                'title' => 'Emergency Maintenance',
                'message' => 'We are performing emergency maintenance to resolve a critical issue. Some features may be temporarily unavailable. We apologize for the inconvenience.',
                'action_url' => '/status',
                'action_text' => 'View Status',
            ],

            // General notifications
            [
                'type' => 'broadcast',
                'category' => 'general',
                'priority' => 'low',
                'title' => 'Welcome to Plyform!',
                'message' => 'Thank you for joining Plyform. We are excited to help you manage your property rental business. Check out our getting started guide to learn more.',
                'action_url' => '/getting-started',
                'action_text' => 'Get Started',
            ],
            [
                'type' => 'broadcast',
                'category' => 'general',
                'priority' => 'medium',
                'title' => 'New Feature: AI Property Descriptions',
                'message' => 'Generate professional property descriptions instantly with our new AI-powered tool. Save time and attract more tenants!',
                'action_url' => '/features/ai-descriptions',
                'action_text' => 'Try It Now',
            ],
            [
                'type' => 'broadcast',
                'category' => 'general',
                'priority' => 'low',
                'title' => 'Monthly Newsletter',
                'message' => 'Check out this month\'s newsletter featuring tips for increasing property visibility, market trends, and success stories from our community.',
                'action_url' => '/newsletter',
                'action_text' => 'Read More',
            ],
            [
                'type' => 'broadcast',
                'category' => 'general',
                'priority' => 'medium',
                'title' => 'System Update',
                'message' => 'We have released a major update with new features, performance improvements, and bug fixes. See what\'s new in the changelog.',
                'action_url' => '/changelog',
                'action_text' => 'View Changes',
            ],
            [
                'type' => 'broadcast',
                'category' => 'general',
                'priority' => 'low',
                'title' => 'Feedback Request',
                'message' => 'Help us improve! Take our 2-minute survey and tell us about your experience with Plyform. Your feedback is valuable to us.',
                'action_url' => '/feedback',
                'action_text' => 'Take Survey',
            ],
        ];

        // Create notifications with varied timestamps
        $notificationCount = 0;
        $now = Carbon::now();

        // Create system notifications (sent to specific users)
        foreach ($allUsers as $user) {
            // Each user gets 5-10 random notifications
            $numNotifications = rand(5, 10);
            $selectedTemplates = collect($templates)->random($numNotifications);

            foreach ($selectedTemplates as $template) {
                $daysAgo = rand(0, 30); // Random within last 30 days
                $createdAt = $now->copy()->subDays($daysAgo)->subHours(rand(0, 23))->subMinutes(rand(0, 59));
                
                // 60% chance of being read if older than 1 day
                $isRead = $daysAgo > 1 && rand(1, 100) <= 60;
                $readAt = $isRead ? $createdAt->copy()->addHours(rand(1, 48)) : null;

                Notification::create([
                    'title' => $template['title'],
                    'message' => $template['message'],
                    'type' => $template['type'],
                    'category' => $template['category'],
                    'priority' => $template['priority'],
                    'sender_id' => $template['type'] === 'broadcast' ? ($admin ? $admin->id : null) : null,
                    'recipient_id' => $user->id,
                    'action_url' => $template['action_url'],
                    'action_text' => $template['action_text'],
                    'read_at' => $readAt,
                    'sent_at' => $createdAt,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                $notificationCount++;
            }
        }

        // Create broadcast notifications (sent to multiple users at once - same timestamp)
        $broadcastTemplates = collect($templates)->where('type', 'broadcast')->take(5);
        
        foreach ($broadcastTemplates as $template) {
            $daysAgo = rand(1, 15);
            $createdAt = $now->copy()->subDays($daysAgo)->subHours(rand(8, 18));
            
            // Broadcast to 50-80% of all users
            $recipientCount = (int)($allUsers->count() * (rand(50, 80) / 100));
            $recipients = $allUsers->random(max(1, $recipientCount));
            
            foreach ($recipients as $user) {
                // Varied read status - 70% read if older than 3 days
                $isRead = $daysAgo > 3 && rand(1, 100) <= 70;
                $readAt = $isRead ? $createdAt->copy()->addHours(rand(1, 72)) : null;

                Notification::create([
                    'title' => $template['title'],
                    'message' => $template['message'],
                    'type' => 'broadcast',
                    'category' => $template['category'],
                    'priority' => $template['priority'],
                    'sender_id' => $admin ? $admin->id : null,
                    'recipient_id' => $user->id,
                    'action_url' => $template['action_url'],
                    'action_text' => $template['action_text'],
                    'read_at' => $readAt,
                    'sent_at' => $createdAt,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                $notificationCount++;
            }
        }

        // Create some scheduled notifications (future)
        $scheduledTemplates = [
            [
                'title' => 'Upcoming Webinar: Property Management Best Practices',
                'message' => 'Join us next week for a free webinar on property management best practices. Learn from industry experts and get your questions answered live!',
                'category' => 'general',
                'priority' => 'medium',
                'action_url' => '/webinars',
                'action_text' => 'Register Now',
            ],
            [
                'title' => 'Scheduled: Monthly System Maintenance',
                'message' => 'This is a reminder that monthly maintenance is scheduled for this weekend. Please save your work and plan accordingly.',
                'category' => 'maintenance',
                'priority' => 'high',
                'action_url' => null,
                'action_text' => null,
            ],
        ];

        foreach ($scheduledTemplates as $template) {
            $scheduledFor = $now->copy()->addDays(rand(1, 7))->setHour(rand(8, 18))->setMinute(0);
            $recipientCount = (int)($allUsers->count() * (rand(20, 50) / 100));
            $recipients = $allUsers->random(max(1, $recipientCount));

            foreach ($recipients as $user) {
                Notification::create([
                    'title' => $template['title'],
                    'message' => $template['message'],
                    'type' => 'broadcast',
                    'category' => $template['category'],
                    'priority' => $template['priority'],
                    'sender_id' => $admin ? $admin->id : null,
                    'recipient_id' => $user->id,
                    'action_url' => $template['action_url'],
                    'action_text' => $template['action_text'],
                    'scheduled_for' => $scheduledFor,
                    'sent_at' => null,
                    'read_at' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                $notificationCount++;
            }
        }

        // Create some pending notifications (not scheduled, not sent)
        $pendingTemplate = [
            'title' => 'Draft: Important Announcement',
            'message' => 'This is a draft notification that has been created but not yet sent to users.',
            'category' => 'general',
            'priority' => 'medium',
            'action_url' => null,
            'action_text' => null,
        ];

        $recipientCount = (int)($allUsers->count() * (rand(10, 20) / 100));
        $recipients = $allUsers->random(max(1, $recipientCount));
        
        foreach ($recipients as $user) {
            Notification::create([
                'title' => $pendingTemplate['title'],
                'message' => $pendingTemplate['message'],
                'type' => 'broadcast',
                'category' => $pendingTemplate['category'],
                'priority' => $pendingTemplate['priority'],
                'sender_id' => $admin ? $admin->id : null,
                'recipient_id' => $user->id,
                'action_url' => $pendingTemplate['action_url'],
                'action_text' => $pendingTemplate['action_text'],
                'scheduled_for' => null,
                'sent_at' => null,
                'read_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $notificationCount++;
        }

        $this->command->info("✅ Created {$notificationCount} notifications successfully!");
        
        // Print statistics
        $stats = [
            'Total' => Notification::count(),
            'Sent' => Notification::whereNotNull('sent_at')->count(),
            'Scheduled' => Notification::whereNotNull('scheduled_for')->whereNull('sent_at')->count(),
            'Pending' => Notification::whereNull('sent_at')->whereNull('scheduled_for')->count(),
            'Read' => Notification::whereNotNull('read_at')->count(),
            'Unread' => Notification::whereNull('read_at')->whereNotNull('sent_at')->count(),
        ];

        $this->command->table(['Metric', 'Count'], collect($stats)->map(fn($count, $metric) => [$metric, $count])->values());
        
        $this->command->info('📊 Notification statistics by category:');
        $categoryStats = Notification::selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');
        $this->command->table(['Category', 'Count'], $categoryStats->map(fn($count, $category) => [ucfirst($category), $count])->values());
        
        $this->command->info('🎯 Notification statistics by priority:');
        $priorityStats = Notification::selectRaw('priority, count(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority');
        $this->command->table(['Priority', 'Count'], $priorityStats->map(fn($count, $priority) => [ucfirst($priority), $count])->values());
    }
}