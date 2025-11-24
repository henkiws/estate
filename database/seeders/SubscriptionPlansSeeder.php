<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlansSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'description' => 'Perfect for small agencies just getting started',
                'price' => 49.00,
                'currency' => 'AUD',
                'billing_period' => 'monthly',
                'features' => [
                    'Up to 5 agents',
                    'Up to 50 properties',
                    '5GB document storage',
                    'Email support',
                    'Basic reporting',
                    'Mobile app access',
                ],
                'max_agents' => 5,
                'max_properties' => 50,
                'document_storage' => true,
                'email_support' => true,
                'priority_support' => false,
                'api_access' => false,
                'custom_branding' => false,
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Most popular plan for growing agencies',
                'price' => 99.00,
                'currency' => 'AUD',
                'billing_period' => 'monthly',
                'features' => [
                    'Up to 20 agents',
                    'Up to 200 properties',
                    '50GB document storage',
                    'Priority email support',
                    'Advanced reporting & analytics',
                    'Mobile app access',
                    'API access',
                    'Custom email templates',
                ],
                'max_agents' => 20,
                'max_properties' => 200,
                'document_storage' => true,
                'email_support' => true,
                'priority_support' => true,
                'api_access' => true,
                'custom_branding' => false,
                'is_active' => true,
                'is_popular' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'For large agencies with advanced needs',
                'price' => 199.00,
                'currency' => 'AUD',
                'billing_period' => 'monthly',
                'features' => [
                    'Unlimited agents',
                    'Unlimited properties',
                    'Unlimited document storage',
                    '24/7 priority support',
                    'Advanced reporting & analytics',
                    'Mobile app access',
                    'Full API access',
                    'Custom branding',
                    'Dedicated account manager',
                    'Custom integrations',
                    'White-label options',
                ],
                'max_agents' => 999,
                'max_properties' => 9999,
                'document_storage' => true,
                'email_support' => true,
                'priority_support' => true,
                'api_access' => true,
                'custom_branding' => true,
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }

        $this->command->info('✅ Subscription plans seeded successfully!');
        $this->command->info('   - Basic: $49/month');
        $this->command->info('   - Professional: $99/month (Popular)');
        $this->command->info('   - Enterprise: $199/month');
    }
}