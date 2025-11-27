<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing plans (optional - remove if you want to keep existing data)
        // SubscriptionPlan::truncate();

        $plans = [
            // BASIC PLAN
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'description' => 'Perfect for small agencies just getting started',
                'price' => 49.00,
                'currency' => 'AUD',
                'billing_period' => 'monthly',
                'stripe_price_id' => null, // Add Stripe price ID when ready
                'stripe_product_id' => null, // Add Stripe product ID when ready
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
            
            // PROFESSIONAL PLAN (Most Popular)
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Most popular plan for growing agencies',
                'price' => 99.00,
                'currency' => 'AUD',
                'billing_period' => 'monthly',
                'stripe_price_id' => null,
                'stripe_product_id' => null,
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
                'is_popular' => true, // Marked as popular
                'sort_order' => 2,
            ],
            
            // ENTERPRISE PLAN
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'For large agencies with advanced needs',
                'price' => 199.00,
                'currency' => 'AUD',
                'billing_period' => 'monthly',
                'stripe_price_id' => null,
                'stripe_product_id' => null,
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
                'max_agents' => 999, // 999 = unlimited
                'max_properties' => 9999, // 9999 = unlimited
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
                ['slug' => $plan['slug']], // Match by slug to avoid duplicates
                $plan
            );
        }

        $this->command->info('');
        $this->command->info('✅ Subscription plans seeded successfully!');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('📦 Plans Created:');
        $this->command->info('   1. Basic        - $49/month  (5 agents, 50 properties)');
        $this->command->info('   2. Professional - $99/month  (20 agents, 200 properties) ⭐ POPULAR');
        $this->command->info('   3. Enterprise   - $199/month (Unlimited agents & properties)');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('');
        $this->command->info('💡 Next Steps:');
        $this->command->info('   1. Create Stripe products and get Price IDs');
        $this->command->info('   2. Update stripe_price_id and stripe_product_id fields');
        $this->command->info('   3. Test subscription flow');
        $this->command->info('');
    }
}