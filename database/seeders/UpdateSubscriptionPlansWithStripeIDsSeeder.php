<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class UpdateSubscriptionPlansWithStripeIDsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * IMPORTANT: After creating products in Stripe Dashboard, update these IDs
     */
    public function run(): void
    {
        // ========================================
        // STEP 1: Create Products in Stripe Dashboard
        // ========================================
        // 1. Go to https://dashboard.stripe.com/test/products
        // 2. Click "Add Product" for each plan below
        // 3. Set up recurring pricing (monthly)
        // 4. Copy the Price ID (starts with price_xxx)
        // 5. Update the arrays below with your Price IDs
        
        $stripePriceIds = [
            // REPLACE THESE WITH YOUR ACTUAL STRIPE PRICE IDs
            'basic' => [
                'monthly' => 'price_1SYK3cKvknUhAB5T3NCjBDGD', // Replace with your Basic Monthly Price ID
                'yearly' => 'price_YYYYYYYYYYYYY',  // Replace with your Basic Yearly Price ID (optional)
            ],
            'professional' => [
                'monthly' => 'price_1SYK4BKvknUhAB5Txxp8VZBX', // Replace with your Professional Monthly Price ID
                'yearly' => 'price_YYYYYYYYYYYYY',  // Replace with your Professional Yearly Price ID (optional)
            ],
            'enterprise' => [
                'monthly' => 'price_1SYK4VKvknUhAB5TNyidkDi6', // Replace with your Enterprise Monthly Price ID
                'yearly' => 'price_YYYYYYYYYYYYY',  // Replace with your Enterprise Yearly Price ID (optional)
            ],
        ];
        
        // ========================================
        // STEP 2: Update Plans with Stripe Price IDs
        // ========================================
        
        // Basic Plan
        $basic = SubscriptionPlan::where('slug', 'basic')->first();
        if ($basic) {
            $basic->update([
                'stripe_price_id' => $stripePriceIds['basic']['monthly'],
                // Optionally store yearly price ID in metadata
                'metadata' => json_encode([
                    'stripe_yearly_price_id' => $stripePriceIds['basic']['yearly'],
                ]),
            ]);
            $this->command->info("✅ Updated Basic plan with Stripe Price ID");
        }
        
        // Professional Plan
        $professional = SubscriptionPlan::where('slug', 'professional')->first();
        if ($professional) {
            $professional->update([
                'stripe_price_id' => $stripePriceIds['professional']['monthly'],
                'metadata' => json_encode([
                    'stripe_yearly_price_id' => $stripePriceIds['professional']['yearly'],
                ]),
            ]);
            $this->command->info("✅ Updated Professional plan with Stripe Price ID");
        }
        
        // Enterprise Plan
        $enterprise = SubscriptionPlan::where('slug', 'enterprise')->first();
        if ($enterprise) {
            $enterprise->update([
                'stripe_price_id' => $stripePriceIds['enterprise']['monthly'],
                'metadata' => json_encode([
                    'stripe_yearly_price_id' => $stripePriceIds['enterprise']['yearly'],
                ]),
            ]);
            $this->command->info("✅ Updated Enterprise plan with Stripe Price ID");
        }
        
        $this->command->info('');
        $this->command->info('====================================');
        $this->command->info('Stripe Price IDs Updated!');
        $this->command->info('====================================');
        $this->command->info('');
        $this->command->warn('⚠️  IMPORTANT: Make sure to update the Price IDs in this file');
        $this->command->warn('    with your actual Stripe Price IDs from the Dashboard');
        $this->command->info('');
    }
}