<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Agency;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class SubscriptionFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Set up Stripe
        Stripe::setApiKey(config('services.stripe.secret'));
        
        // Seed roles and permissions
        $this->artisan('db:seed', ['--class' => 'RoleAndPermissionSeeder']);
        $this->artisan('db:seed', ['--class' => 'SubscriptionPlansSeeder']);
    }

    /** @test */
    public function approved_agency_can_access_subscription_page()
    {
        // Create approved agency
        $agency = Agency::factory()->create(['status' => 'approved']);
        $user = User::factory()->create(['agency_id' => $agency->id]);
        $user->assignRole('agency');

        $response = $this->actingAs($user)->get(route('agency.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Choose Your Perfect Plan');
    }

    /** @test */
    public function pending_agency_cannot_subscribe()
    {
        $agency = Agency::factory()->create(['status' => 'pending']);
        $user = User::factory()->create(['agency_id' => $agency->id]);
        $user->assignRole('agency');
        
        $plan = SubscriptionPlan::first();

        $response = $this->actingAs($user)->post(route('agency.subscription.checkout', $plan->id), [
            'billing_cycle' => 'monthly'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Your agency must be approved before subscribing.');
    }

    /** @test */
    public function subscription_creates_stripe_checkout_session()
    {
        $agency = Agency::factory()->create(['status' => 'approved']);
        $user = User::factory()->create(['agency_id' => $agency->id]);
        $user->assignRole('agency');
        
        $plan = SubscriptionPlan::first();

        $response = $this->actingAs($user)->post(route('agency.subscription.checkout', $plan->id), [
            'billing_cycle' => 'monthly'
        ]);

        // Should redirect to Stripe
        $response->assertRedirect();
        
        // Transaction should be created
        $this->assertDatabaseHas('transactions', [
            'agency_id' => $agency->id,
            'subscription_plan_id' => $plan->id,
            'status' => 'pending',
            'type' => 'subscription',
        ]);
    }

    /** @test */
    public function yearly_subscription_applies_discount()
    {
        $agency = Agency::factory()->create(['status' => 'approved']);
        $user = User::factory()->create(['agency_id' => $agency->id]);
        $user->assignRole('agency');
        
        $plan = SubscriptionPlan::first();
        $expectedAmount = $plan->price * 12 * 0.8; // 20% discount

        $response = $this->actingAs($user)->post(route('agency.subscription.checkout', $plan->id), [
            'billing_cycle' => 'yearly'
        ]);

        $transaction = Transaction::latest()->first();
        $this->assertEquals($expectedAmount, $transaction->amount);
    }

    /** @test */
    public function webhook_activates_subscription_after_payment()
    {
        $agency = Agency::factory()->create(['status' => 'approved']);
        $plan = SubscriptionPlan::first();

        // Simulate Stripe webhook payload
        $payload = [
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id' => 'cs_test_123',
                    'subscription' => 'sub_test_123',
                    'customer' => 'cus_test_123',
                    'amount_total' => $plan->price * 100,
                    'currency' => 'aud',
                    'metadata' => [
                        'agency_id' => $agency->id,
                        'plan_id' => $plan->id,
                        'billing_cycle' => 'monthly',
                    ],
                ],
            ],
        ];

        // Note: In real tests, you'd need to sign this payload with Stripe webhook secret
        // For now, we'll test the handler method directly
        $controller = new \App\Http\Controllers\Agency\SubscriptionController();
        $controller->handleCheckoutCompleted((object) $payload['data']['object']);

        // Verify subscription was created
        $this->assertDatabaseHas('subscriptions', [
            'agency_id' => $agency->id,
            'subscription_plan_id' => $plan->id,
            'stripe_subscription_id' => 'sub_test_123',
            'status' => 'active',
        ]);

        // Verify agency was activated
        $agency->refresh();
        $this->assertEquals('active', $agency->status);
    }

    /** @test */
    public function success_page_displays_subscription_details()
    {
        $agency = Agency::factory()->create(['status' => 'active']);
        $plan = SubscriptionPlan::first();
        $subscription = Subscription::factory()->create([
            'agency_id' => $agency->id,
            'subscription_plan_id' => $plan->id,
            'status' => 'active',
        ]);
        
        $user = User::factory()->create(['agency_id' => $agency->id]);
        $user->assignRole('agency');

        // Mock Stripe session
        $mockSession = (object) [
            'id' => 'cs_test_123',
            'amount_total' => $plan->price * 100,
            'payment_method_types' => ['card'],
            'metadata' => (object) [
                'agency_id' => $agency->id,
                'plan_id' => $plan->id,
                'billing_cycle' => 'monthly',
            ],
        ];

        $response = $this->actingAs($user)
            ->withSession(['stripe_session' => $mockSession])
            ->get(route('agency.subscription.success', ['session_id' => 'cs_test_123']));

        $response->assertStatus(200);
        $response->assertSee('Payment Successful');
        $response->assertSee($plan->name);
    }
}