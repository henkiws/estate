<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        // Set Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create Stripe checkout session
     */
    public function checkout(Request $request, $planId)
    {
        $request->validate([
            'billing_cycle' => 'required|in:monthly,yearly',
        ]);

        $user = Auth::user();
        $agency = $user->agency;

        // Check agency status
        if ($agency->status !== 'approved') {
            return back()->with('error', 'Your agency must be approved before subscribing.');
        }

        // Get the plan
        $plan = SubscriptionPlan::findOrFail($planId);

        // Calculate price based on billing cycle
        $amount = $request->billing_cycle === 'yearly' 
            ? $plan->price * 12 * 0.8  // 20% discount for yearly
            : $plan->price;

        try {
            // Create Stripe Checkout Session
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'aud',
                        'unit_amount' => $amount * 100, // Convert to cents
                        'product_data' => [
                            'name' => $plan->name . ' Plan',
                            'description' => $request->billing_cycle === 'yearly' 
                                ? 'Yearly subscription (20% discount)' 
                                : 'Monthly subscription',
                        ],
                        'recurring' => [
                            'interval' => $request->billing_cycle === 'yearly' ? 'year' : 'month',
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'subscription',
                'success_url' => route('agency.subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('agency.subscription.cancel'),
                'client_reference_id' => $agency->id,
                'metadata' => [
                    'agency_id' => $agency->id,
                    'plan_id' => $plan->id,
                    'billing_cycle' => $request->billing_cycle,
                ],
            ]);

            // Log the checkout attempt
            Log::info('Stripe checkout session created', [
                'agency_id' => $agency->id,
                'plan_id' => $plan->id,
                'session_id' => $session->id,
            ]);

            // Create pending transaction
            Transaction::create([
                'agency_id' => $agency->id,
                'subscription_plan_id' => $plan->id,
                'stripe_payment_id' => $session->id,
                'amount' => $amount,
                'currency' => 'AUD',
                'status' => 'pending',
                'type' => 'subscription',
                'billing_cycle' => $request->billing_cycle,
                'metadata' => json_encode([
                    'session_id' => $session->id,
                    'plan_name' => $plan->name,
                ]),
            ]);

            // Redirect to Stripe Checkout
            return redirect($session->url);

        } catch (\Exception $e) {
            Log::error('Stripe checkout error: ' . $e->getMessage(), [
                'agency_id' => $agency->id,
                'plan_id' => $plan->id,
            ]);

            return back()->with('error', 'Failed to create checkout session. Please try again.');
        }
    }

    /**
     * Handle successful payment
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('agency.dashboard')
                ->with('error', 'Invalid session.');
        }

        try {
            // Retrieve the session
            $session = Session::retrieve($sessionId);

            $agencyId = $session->metadata->agency_id;
            $planId = $session->metadata->plan_id;
            $billingCycle = $session->metadata->billing_cycle;

            $agency = Agency::findOrFail($agencyId);
            $plan = SubscriptionPlan::findOrFail($planId);

            // Check if subscription already created
            $existingSubscription = Subscription::where('agency_id', $agency->id)
                ->where('stripe_subscription_id', $session->subscription)
                ->first();

            if ($existingSubscription) {
                return redirect()->route('agency.dashboard')
                    ->with('success', 'Welcome! Your subscription is now active.');
            }

            // This will be handled by webhook, but we can show success message
            return view('agency.subscription.success', compact('agency', 'plan', 'session'));

        } catch (\Exception $e) {
            Log::error('Subscription success page error: ' . $e->getMessage());

            return redirect()->route('agency.dashboard')
                ->with('info', 'Your payment is being processed. You will receive a confirmation email shortly.');
        }
    }

    /**
     * Handle cancelled payment
     */
    public function cancel()
    {
        return redirect()->route('agency.dashboard')
            ->with('warning', 'Subscription cancelled. You can try again anytime.');
    }

    /**
     * Handle Stripe webhooks
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Webhook invalid payload: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            Log::error('Webhook invalid signature: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $this->handleCheckoutCompleted($event->data->object);
                break;

            case 'invoice.payment_succeeded':
                $this->handlePaymentSucceeded($event->data->object);
                break;

            case 'invoice.payment_failed':
                $this->handlePaymentFailed($event->data->object);
                break;

            case 'customer.subscription.deleted':
                $this->handleSubscriptionDeleted($event->data->object);
                break;

            default:
                Log::info('Unhandled webhook event: ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Handle checkout session completed
     */
    protected function handleCheckoutCompleted($session)
    {
        try {
            $agencyId = $session->metadata->agency_id;
            $planId = $session->metadata->plan_id;
            $billingCycle = $session->metadata->billing_cycle;

            $agency = Agency::findOrFail($agencyId);
            $plan = SubscriptionPlan::findOrFail($planId);

            // Create subscription
            $subscription = Subscription::create([
                'agency_id' => $agency->id,
                'subscription_plan_id' => $plan->id,
                'stripe_subscription_id' => $session->subscription,
                'stripe_customer_id' => $session->customer,
                'status' => 'active',
                'billing_cycle' => $billingCycle,
                'current_period_start' => now(),
                'current_period_end' => $billingCycle === 'yearly' 
                    ? now()->addYear() 
                    : now()->addMonth(),
            ]);

            // Update agency status to active
            $agency->update([
                'status' => 'active',
                'subscription_id' => $subscription->id,
            ]);

            // Update transaction
            Transaction::where('stripe_payment_id', $session->id)->update([
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            // Create initial transaction record
            Transaction::create([
                'agency_id' => $agency->id,
                'subscription_plan_id' => $plan->id,
                'subscription_id' => $subscription->id,
                'stripe_payment_id' => $session->payment_intent,
                'amount' => $session->amount_total / 100,
                'currency' => strtoupper($session->currency),
                'status' => 'completed',
                'type' => 'subscription',
                'billing_cycle' => $billingCycle,
                'paid_at' => now(),
                'metadata' => json_encode([
                    'session_id' => $session->id,
                    'customer_id' => $session->customer,
                ]),
            ]);

            Log::info('Subscription activated', [
                'agency_id' => $agency->id,
                'subscription_id' => $subscription->id,
            ]);

            // TODO: Send welcome email

        } catch (\Exception $e) {
            Log::error('Checkout completed webhook error: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment
     */
    protected function handlePaymentSucceeded($invoice)
    {
        try {
            $subscription = Subscription::where('stripe_subscription_id', $invoice->subscription)->first();

            if ($subscription) {
                // Create transaction record
                Transaction::create([
                    'agency_id' => $subscription->agency_id,
                    'subscription_plan_id' => $subscription->subscription_plan_id,
                    'subscription_id' => $subscription->id,
                    'stripe_payment_id' => $invoice->payment_intent,
                    'amount' => $invoice->amount_paid / 100,
                    'currency' => strtoupper($invoice->currency),
                    'status' => 'completed',
                    'type' => 'renewal',
                    'billing_cycle' => $subscription->billing_cycle,
                    'paid_at' => now(),
                    'metadata' => json_encode([
                        'invoice_id' => $invoice->id,
                    ]),
                ]);

                Log::info('Payment succeeded', [
                    'subscription_id' => $subscription->id,
                    'amount' => $invoice->amount_paid / 100,
                ]);

                // TODO: Send payment receipt email
            }

        } catch (\Exception $e) {
            Log::error('Payment succeeded webhook error: ' . $e->getMessage());
        }
    }

    /**
     * Handle failed payment
     */
    protected function handlePaymentFailed($invoice)
    {
        try {
            $subscription = Subscription::where('stripe_subscription_id', $invoice->subscription)->first();

            if ($subscription) {
                // Create failed transaction record
                Transaction::create([
                    'agency_id' => $subscription->agency_id,
                    'subscription_plan_id' => $subscription->subscription_plan_id,
                    'subscription_id' => $subscription->id,
                    'stripe_payment_id' => $invoice->payment_intent,
                    'amount' => $invoice->amount_due / 100,
                    'currency' => strtoupper($invoice->currency),
                    'status' => 'failed',
                    'type' => 'renewal',
                    'billing_cycle' => $subscription->billing_cycle,
                    'metadata' => json_encode([
                        'invoice_id' => $invoice->id,
                        'error' => 'Payment failed',
                    ]),
                ]);

                Log::warning('Payment failed', [
                    'subscription_id' => $subscription->id,
                    'invoice_id' => $invoice->id,
                ]);

                // TODO: Send payment failed email
            }

        } catch (\Exception $e) {
            Log::error('Payment failed webhook error: ' . $e->getMessage());
        }
    }

    /**
     * Handle subscription deleted/cancelled
     */
    protected function handleSubscriptionDeleted($stripeSubscription)
    {
        try {
            $subscription = Subscription::where('stripe_subscription_id', $stripeSubscription->id)->first();

            if ($subscription) {
                $subscription->update([
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);

                // Update agency status
                $subscription->agency->update([
                    'status' => 'approved', // Back to approved, needs new subscription
                ]);

                Log::info('Subscription cancelled', [
                    'subscription_id' => $subscription->id,
                ]);

                // TODO: Send subscription cancelled email
            }

        } catch (\Exception $e) {
            Log::error('Subscription deleted webhook error: ' . $e->getMessage());
        }
    }
}