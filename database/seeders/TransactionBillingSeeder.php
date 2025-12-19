<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agency;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use App\Models\AgencyBilling;
use Carbon\Carbon;

class TransactionBillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔄 Creating subscription, billing, and transaction data...');
        $this->command->info('');

        // Get active agencies that need subscription data
        $agencies = Agency::whereIn('status', ['active', 'approved'])->get();

        if ($agencies->isEmpty()) {
            $this->command->warn('⚠️  No active or approved agencies found. Run SampleDataSeeder first!');
            return;
        }

        // Get subscription plans
        $basicPlan = SubscriptionPlan::where('slug', 'basic')->first();
        $professionalPlan = SubscriptionPlan::where('slug', 'professional')->first();
        $enterprisePlan = SubscriptionPlan::where('slug', 'enterprise')->first();

        if (!$basicPlan || !$professionalPlan || !$enterprisePlan) {
            $this->command->warn('⚠️  Subscription plans not found. Run SubscriptionPlansSeeder first!');
            return;
        }

        foreach ($agencies as $agency) {
            // Create billing information
            $this->createBillingInfo($agency);

            if ($agency->status === 'active') {
                // Active agencies have subscriptions and transaction history
                $this->createActiveSubscription($agency, [$basicPlan, $professionalPlan, $enterprisePlan]);
            } elseif ($agency->status === 'approved') {
                // Approved agencies have no subscription yet
                $this->command->info("⏸️  {$agency->agency_name} - Approved (No subscription yet)");
            }

            $this->command->info('');
        }

        $this->command->info('');
        $this->command->info('✅ Transaction and billing data seeded successfully!');
        $this->printSummary();
    }

    /**
     * Create billing information for agency
     */
    private function createBillingInfo(Agency $agency)
    {
        AgencyBilling::updateOrCreate(
            ['agency_id' => $agency->id],
            [
                'billing_contact_name' => $agency->license_holder_name,
                'billing_email' => $agency->business_email,
                'billing_phone' => $agency->business_phone,
                'billing_address' => $agency->business_address . ', ' . $agency->state . ' ' . $agency->postcode,
                'payment_method' => 'card',
            ]
        );
    }

    /**
     * Create active subscription with full transaction history
     */
    private function createActiveSubscription(Agency $agency, array $plans)
    {
        // Randomly select a plan (weighted towards Professional)
        $planWeights = [
            $plans[0]->id => 20,  // Basic: 20%
            $plans[1]->id => 60,  // Professional: 60%
            $plans[2]->id => 20,  // Enterprise: 20%
        ];
        
        $selectedPlanId = $this->weightedRandom($planWeights);
        $plan = SubscriptionPlan::find($selectedPlanId);

        // Determine subscription start date (1-12 months ago)
        $monthsAgo = rand(1, 12);
        $startDate = Carbon::now()->subMonths($monthsAgo)->startOfMonth();
        
        // Create subscription
        $subscription = Subscription::create([
            'agency_id' => $agency->id,
            'subscription_plan_id' => $plan->id,
            'stripe_subscription_id' => 'sub_' . strtoupper(bin2hex(random_bytes(12))),
            'stripe_customer_id' => 'cus_' . strtoupper(bin2hex(random_bytes(12))),
            'status' => $this->determineSubscriptionStatus(),
            'trial_ends_at' => null, // No trial for sample data
            'current_period_start' => Carbon::now()->startOfMonth(),
            'current_period_end' => Carbon::now()->addMonth()->startOfMonth(),
            'cancelled_at' => null,
            'ends_at' => null,
        ]);

        $this->command->info("📊 {$agency->agency_name}:");
        $this->command->info("   Plan: {$plan->name} (\${$plan->price}/month)");
        $this->command->info("   Status: {$subscription->status}");
        $this->command->info("   Started: {$startDate->format('M Y')}");

        // Create transaction history for each month
        $transactionCount = 0;
        $currentDate = $startDate->copy();
        
        while ($currentDate->lte(Carbon::now())) {
            $transactionCount++;
            
            // Determine if this payment succeeded or failed (95% success rate)
            $isSuccessful = rand(1, 100) <= 95;
            
            $this->createTransaction(
                $agency,
                $subscription,
                $plan,
                $currentDate,
                $isSuccessful,
                $transactionCount
            );

            $currentDate->addMonth();
        }

        $this->command->info("   Transactions: {$transactionCount} created");
    }

    /**
     * Create individual transaction
     */
    private function createTransaction(
        Agency $agency,
        Subscription $subscription,
        SubscriptionPlan $plan,
        Carbon $date,
        bool $isSuccessful,
        int $sequence
    ) {
        $cardLast4 = ['4242', '5555', '3782', '6011'][rand(0, 3)];

        $paymentMethods = [
            ['method' => 'card', 'brand' => 'visa'],
            ['method' => 'card', 'brand' => 'mastercard'],
            ['method' => 'card', 'brand' => 'amex'],
        ];

        $payment = $paymentMethods[array_rand($paymentMethods)];

        $paymentMethod = $payment['method'];
        $cardBrand     = $payment['brand'];

        $status = $isSuccessful
            ? 'completed'
            : (rand(0, 1) ? 'failed' : 'pending');

        
        $transaction = Transaction::create([
            'agency_id' => $agency->id,
            'subscription_id' => $subscription->id,
            'transaction_id' => 'txn_' . strtoupper(bin2hex(random_bytes(10))),
            'amount' => $plan->price,
            'currency' => $plan->currency,
            'type' => 'subscription',
            'status' => $status,
            'payment_method' => $paymentMethod,
            'payment_method_last4' => $cardLast4,
            'stripe_charge_id' => $isSuccessful ? 'ch_' . strtoupper(bin2hex(random_bytes(12))) : null,
            'stripe_invoice_id' => $isSuccessful ? 'in_' . strtoupper(bin2hex(random_bytes(12))) : null,
            'stripe_response' => $this->generateStripeResponse($isSuccessful),
            'description' => $plan->name . ' Plan - Monthly Subscription',
            'failure_reason' => $isSuccessful ? null : $this->getRandomFailureReason(),
            'metadata' => [
                'plan_name' => $plan->name,
                'billing_period' => $plan->billing_period,
                'sequence' => $sequence,
                'agency_name' => $agency->agency_name,
            ],
            'created_at' => $date->copy()->addDays(rand(1, 5))->setTime(rand(0, 23), rand(0, 59)),
            'updated_at' => $date->copy()->addDays(rand(1, 5))->setTime(rand(0, 23), rand(0, 59)),
        ]);

        // Occasionally add refund transactions (5% chance for completed payments)
        if ($isSuccessful && rand(1, 100) <= 5 && $sequence > 2) {
            $this->createRefundTransaction($agency, $subscription, $plan, $transaction, $date);
        }
    }

    /**
     * Create refund transaction
     */
    private function createRefundTransaction(
        Agency $agency,
        Subscription $subscription,
        SubscriptionPlan $plan,
        Transaction $originalTransaction,
        Carbon $date
    ) {
        Transaction::create([
            'agency_id' => $agency->id,
            'subscription_id' => $subscription->id,
            'transaction_id' => 'txn_' . strtoupper(bin2hex(random_bytes(10))),
            'amount' => -$plan->price, // Negative for refund
            'currency' => $plan->currency,
            'type' => 'refund',
            'status' => 'completed',
            'payment_method' => $originalTransaction->payment_method,
            'payment_method_last4' => $originalTransaction->payment_method_last4,
            'stripe_charge_id' => 're_' . strtoupper(bin2hex(random_bytes(12))),
            'stripe_invoice_id' => null,
            'stripe_response' => [
                'refund_id' => 're_' . strtoupper(bin2hex(random_bytes(12))),
                'reason' => 'requested_by_customer',
                'status' => 'succeeded',
            ],
            'description' => 'Refund - ' . $plan->name . ' Plan',
            'failure_reason' => null,
            'metadata' => [
                'original_transaction_id' => $originalTransaction->id,
                'refund_reason' => 'Customer requested refund',
            ],
            'created_at' => $date->copy()->addDays(rand(7, 14))->setTime(rand(0, 23), rand(0, 59)),
            'updated_at' => $date->copy()->addDays(rand(7, 14))->setTime(rand(0, 23), rand(0, 59)),
        ]);
    }

    /**
     * Generate realistic Stripe response
     */
    private function generateStripeResponse(bool $isSuccessful): array
    {
        if ($isSuccessful) {
            return [
                'id' => 'ch_' . strtoupper(bin2hex(random_bytes(12))),
                'object' => 'charge',
                'amount' => 9900,
                'currency' => 'aud',
                'status' => 'succeeded',
                'paid' => true,
                'captured' => true,
                'receipt_url' => 'https://pay.stripe.com/receipts/' . bin2hex(random_bytes(16)),
                'billing_details' => [
                    'email' => 'billing@agency.com',
                    'name' => 'Agency Name',
                ],
            ];
        } else {
            return [
                'error' => [
                    'code' => $this->getRandomErrorCode(),
                    'message' => $this->getRandomFailureReason(),
                    'type' => 'card_error',
                ],
            ];
        }
    }

    /**
     * Get random failure reason
     */
    private function getRandomFailureReason(): string
    {
        $reasons = [
            'Your card has insufficient funds.',
            'Your card was declined.',
            'Your card has expired.',
            'Your card number is incorrect.',
            'Your card\'s security code is incorrect.',
            'An error occurred while processing your card.',
            'Your card does not support this type of purchase.',
            'The payment was declined by your bank.',
        ];

        return $reasons[array_rand($reasons)];
    }

    /**
     * Get random Stripe error code
     */
    private function getRandomErrorCode(): string
    {
        $codes = [
            'insufficient_funds',
            'card_declined',
            'expired_card',
            'incorrect_number',
            'incorrect_cvc',
            'processing_error',
        ];

        return $codes[array_rand($codes)];
    }

    /**
     * Determine subscription status (weighted)
     */
    private function determineSubscriptionStatus(): string
    {
        $weights = [
            'active' => 85,      // 85% active
            'trialing' => 5,     // 5% trialing
            'cancelled' => 5,    // 5% cancelled
            'expired' => 5,      // 5% expired
        ];

        return $this->weightedRandom($weights);
    }

    /**
     * Weighted random selection
     */
    private function weightedRandom(array $weights): mixed
    {
        $total = array_sum($weights);
        $random = rand(1, $total);
        
        $sum = 0;
        foreach ($weights as $key => $weight) {
            $sum += $weight;
            if ($random <= $sum) {
                return $key;
            }
        }
        
        return array_key_first($weights);
    }

    /**
     * Print summary statistics
     */
    private function printSummary()
    {
        $totalSubscriptions = Subscription::count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $totalTransactions = Transaction::count();
        $completedTransactions = Transaction::where('status', 'completed')->count();
        $failedTransactions = Transaction::where('status', 'failed')->count();
        $totalRevenue = Transaction::where('status', 'completed')
            ->where('amount', '>', 0)
            ->sum('amount');
        $totalRefunds = Transaction::where('type', 'refund')->sum('amount');

        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('📊 SUMMARY STATISTICS');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('');
        $this->command->info('💳 Subscriptions:');
        $this->command->info("   Total: {$totalSubscriptions}");
        $this->command->info("   Active: {$activeSubscriptions}");
        $this->command->info('');
        $this->command->info('💰 Transactions:');
        $this->command->info("   Total: {$totalTransactions}");
        $this->command->info("   Completed: {$completedTransactions}");
        $this->command->info("   Failed: {$failedTransactions}");
        $this->command->info('');
        $this->command->info('💵 Revenue:');
        $this->command->info("   Total Revenue: \$" . number_format($totalRevenue, 2));
        $this->command->info("   Total Refunds: \$" . number_format(abs($totalRefunds), 2));
        $this->command->info("   Net Revenue: \$" . number_format($totalRevenue + $totalRefunds, 2));
        $this->command->info('');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('');
        $this->command->info('🎯 TESTING SCENARIOS:');
        $this->command->info('');
        $this->command->info('1. Active Subscription:');
        $this->command->info('   Login as: john@sydneypremier.com.au');
        $this->command->info('   → View billing dashboard');
        $this->command->info('   → See monthly payment history');
        $this->command->info('   → Check subscription status & renewal date');
        $this->command->info('');
        $this->command->info('2. No Subscription (Approved):');
        $this->command->info('   Login as: sarah@mpgrealty.com.au');
        $this->command->info('   → See "No Active Subscription" message');
        $this->command->info('   → Prompt to choose a plan');
        $this->command->info('');
        $this->command->info('3. Failed Payments:');
        $this->command->info('   → Check transaction history for failed status');
        $this->command->info('   → View failure reasons');
        $this->command->info('');
        $this->command->info('4. Refunds:');
        $this->command->info('   → Some completed payments have refund transactions');
        $this->command->info('   → Negative amounts shown in history');
        $this->command->info('');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}