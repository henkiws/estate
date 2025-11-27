<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
                'stripe_price_id' => null, // Add your Stripe price ID
                'stripe_product_id' => null, // Add your Stripe product ID
                'features' => json_encode([
                    'Up to 5 active agents',
                    '50 property listings',
                    'Basic analytics dashboard',
                    'Email support',
                    'Mobile app access',
                    'Standard templates',
                ]),
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
                'description' => 'Most popular for growing agencies',
                'price' => 99.00,
                'currency' => 'AUD',
                'billing_period' => 'monthly',
                'stripe_price_id' => null, // Add your Stripe price ID
                'stripe_product_id' => null, // Add your Stripe product ID
                'features' => json_encode([
                    'Up to 20 active agents',
                    'Unlimited property listings',
                    'Advanced analytics & reports',
                    'Priority email & chat support',
                    'Mobile app access',
                    'Custom branding',
                    'Lead management system',
                    'Automated workflows',
                    'API access',
                ]),
                'max_agents' => 20,
                'max_properties' => 999999, // Unlimited (large number)
                'document_storage' => true,
                'email_support' => true,
                'priority_support' => true,
                'api_access' => true,
                'custom_branding' => true,
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
                'stripe_price_id' => null, // Add your Stripe price ID
                'stripe_product_id' => null, // Add your Stripe product ID
                'features' => json_encode([
                    'Unlimited agents',
                    'Unlimited property listings',
                    'Enterprise-grade analytics',
                    '24/7 phone & priority support',
                    'Mobile app access',
                    'White-label solution',
                    'Dedicated account manager',
                    'Custom integrations',
                    'Advanced API access',
                    'Custom training sessions',
                    'SLA guarantee',
                ]),
                'max_agents' => 999999, // Unlimited (large number)
                'max_properties' => 999999, // Unlimited (large number)
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
            SubscriptionPlan::updateOrCreate(
                ['slug' => $plan['slug']], // Match by slug
                $plan // Update or create with these values
            );
        }

        $this->command->info('✅ Subscription plans seeded successfully!');
        $this->command->info('📦 Created 3 plans: Basic (AUD $49), Professional (AUD $99), Enterprise (AUD $199)');
    }
}