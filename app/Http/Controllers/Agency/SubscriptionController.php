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
        $validated = $request->validate([
            'billing_cycle' => 'required|in:monthly,yearly',
        ]);

        $user = Auth::user();
        $agency = $user->agency;

        // Check if agency exists
        if (!$agency) {
            Log::error('Checkout failed: No agency found', ['user_id' => $user->id]);
            return back()->with('error', 'No agency found for your account. Please contact support.');
        }

        // Check agency status
        if ($agency->status !== 'approved') {
            Log::warning('Checkout failed: Agency not approved', [
                'agency_id' => $agency->id,
                'status' => $agency->status
            ]);
            return back()->with('error', 'Your agency must be approved before subscribing. Current status: ' . ucfirst($agency->status));
        }

        // Get the plan
        $plan = SubscriptionPlan::find($planId);
        
        if (!$plan) {
            Log::error('Checkout failed: Plan not found', ['plan_id' => $planId]);
            return back()->with('error', 'Subscription plan not found.');
        }

        // Check if plan is active
        if (!$plan->is_active) {
            Log::warning('Checkout failed: Plan inactive', ['plan_id' => $planId]);
            return back()->with('error', 'This subscription plan is no longer available.');
        }

        // Check if Stripe Price ID exists
        if (empty($plan->stripe_price_id)) {
            Log::error('Checkout failed: No Stripe Price ID', [
                'plan_id' => $planId,
                'plan_name' => $plan->name
            ]);
            return back()->with('error', 'This plan is not configured properly. Please contact support. (Missing Stripe Price ID)');
        }

        // Calculate price based on billing cycle
        $amount = $request->billing_cycle === 'yearly' 
            ? $plan->price * 12 * 0.8  // 20% discount for yearly
            : $plan->price;

        Log::info('Starting Stripe checkout', [
            'agency_id' => $agency->id,
            'plan_id' => $plan->id,
            'billing_cycle' => $request->billing_cycle,
            'amount' => $amount,
            'stripe_price_id' => $plan->stripe_price_id,
        ]);

        try {
            // Determine which Stripe Price ID to use
            $stripePriceId = $plan->stripe_price_id;
            
            // If yearly billing, check if we have a yearly price ID in metadata
            if ($request->billing_cycle === 'yearly') {
                $metadata = is_string($plan->metadata) ? json_decode($plan->metadata, true) : $plan->metadata;
                if (isset($metadata['yearly_price_id']) && !empty($metadata['yearly_price_id'])) {
                    $stripePriceId = $metadata['yearly_price_id'];
                    Log::info('Using yearly price ID from metadata', ['price_id' => $stripePriceId]);
                }
            }

            // Create Stripe Checkout Session
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price' => $stripePriceId,
                    'quantity' => 1,
                ]],
                'mode' => 'subscription',
                'success_url' => route('agency.subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('agency.subscription.cancel'),
                'client_reference_id' => (string)$agency->id,
                'customer_email' => $agency->business_email,
                'metadata' => [
                    'agency_id' => (string)$agency->id,
                    'plan_id' => (string)$plan->id,
                    'billing_cycle' => $request->billing_cycle,
                    'agency_name' => $agency->agency_name,
                ],
            ]);

            // Log the successful session creation
            Log::info('Stripe checkout session created successfully', [
                'agency_id' => $agency->id,
                'plan_id' => $plan->id,
                'session_id' => $session->id,
                'checkout_url' => $session->url,
            ]);

            // Create pending transaction
            Transaction::create([
                'agency_id' => $agency->id,
                'subscription_plan_id' => $plan->id,
                'transaction_id' => 'pending_' . $session->id, // Temporary ID until payment completes
                'stripe_payment_id' => $session->id,
                'amount' => $amount,
                'currency' => 'AUD',
                'status' => 'pending',
                'type' => 'subscription',
                'billing_cycle' => $request->billing_cycle,
                'metadata' => json_encode([
                    'session_id' => $session->id,
                    'plan_name' => $plan->name,
                    'checkout_created_at' => now()->toDateTimeString(),
                ]),
            ]);

            // Redirect to Stripe Checkout
            return redirect($session->url);

        } catch (\Stripe\Exception\InvalidRequestException $e) {
            Log::error('Stripe Invalid Request: ' . $e->getMessage(), [
                'agency_id' => $agency->id,
                'plan_id' => $plan->id,
                'stripe_price_id' => $stripePriceId ?? 'unknown',
                'error_type' => 'InvalidRequestException',
                'error_message' => $e->getMessage(),
                'error_code' => $e->getStripeCode(),
            ]);

            // User-friendly error message
            $errorMessage = 'Failed to create checkout session. ';
            if (str_contains($e->getMessage(), 'No such price')) {
                $errorMessage .= 'The selected plan is not properly configured in Stripe. Please contact support.';
            } elseif (str_contains($e->getMessage(), 'api_key')) {
                $errorMessage .= 'Payment system configuration error. Please contact support.';
            } else {
                $errorMessage .= 'Please try again or contact support if the issue persists.';
            }

            return back()->with('error', $errorMessage);

        } catch (\Stripe\Exception\AuthenticationException $e) {
            Log::error('Stripe Authentication Error: ' . $e->getMessage(), [
                'error_type' => 'AuthenticationException',
                'api_key_set' => config('services.stripe.secret') ? 'YES' : 'NO',
                'api_key_prefix' => substr(config('services.stripe.secret'), 0, 7),
            ]);

            return back()->with('error', 'Payment system authentication failed. Please contact support.');

        } catch (\Stripe\Exception\ApiConnectionException $e) {
            Log::error('Stripe API Connection Error: ' . $e->getMessage(), [
                'error_type' => 'ApiConnectionException',
            ]);

            return back()->with('error', 'Could not connect to payment system. Please check your internet connection and try again.');

        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe API Error: ' . $e->getMessage(), [
                'error_type' => get_class($e),
                'error_message' => $e->getMessage(),
            ]);

            return back()->with('error', 'Payment system error. Please try again later or contact support.');

        } catch (\Exception $e) {
            Log::error('General checkout error: ' . $e->getMessage(), [
                'agency_id' => $agency->id,
                'plan_id' => $plan->id,
                'error_type' => get_class($e),
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'An unexpected error occurred. Please try again or contact support.');
        }
    }

    /**
     * Handle successful payment
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            Log::warning('Success page accessed without session_id');
            return redirect()->route('agency.dashboard')
                ->with('error', 'Invalid session.');
        }

        try {
            // Retrieve the session
            $session = Session::retrieve($sessionId);

            Log::info('Success page accessed', [
                'session_id' => $sessionId,
                'subscription_id' => $session->subscription ?? 'none',
            ]);

            $agencyId = $session->metadata->agency_id ?? null;
            $planId = $session->metadata->plan_id ?? null;
            $billingCycle = $session->metadata->billing_cycle ?? 'monthly';

            if (!$agencyId || !$planId) {
                Log::error('Success page: Missing metadata', [
                    'session_id' => $sessionId,
                    'metadata' => $session->metadata,
                ]);
                return redirect()->route('agency.dashboard')
                    ->with('warning', 'Payment processed, but we could not retrieve all details. Please contact support if your subscription is not activated.');
            }

            $agency = Agency::find($agencyId);
            $plan = SubscriptionPlan::find($planId);

            if (!$agency || !$plan) {
                Log::error('Success page: Agency or Plan not found', [
                    'agency_id' => $agencyId,
                    'plan_id' => $planId,
                ]);
                return redirect()->route('agency.dashboard')
                    ->with('error', 'Could not load subscription details.');
            }

            // Check if subscription already created
            $existingSubscription = Subscription::where('agency_id', $agency->id)
                ->where('stripe_subscription_id', $session->subscription)
                ->first();

            if ($existingSubscription) {
                Log::info('Subscription already exists for session', [
                    'session_id' => $sessionId,
                    'subscription_id' => $existingSubscription->id,
                ]);
                return view('agency.subscription.success', compact('agency', 'plan', 'session'))
                    ->with('success', 'Welcome! Your subscription is now active.');
            }

            // This will be handled by webhook, but we can show success message
            return view('agency.subscription.success', compact('agency', 'plan', 'session'));

        } catch (\Stripe\Exception\InvalidRequestException $e) {
            Log::error('Success page Stripe error: ' . $e->getMessage(), [
                'session_id' => $sessionId,
            ]);

            return redirect()->route('agency.dashboard')
                ->with('info', 'Your payment is being processed. You will receive a confirmation email shortly.');

        } catch (\Exception $e) {
            Log::error('Success page error: ' . $e->getMessage(), [
                'session_id' => $sessionId,
                'error_type' => get_class($e),
            ]);

            return redirect()->route('agency.dashboard')
                ->with('info', 'Your payment is being processed. You will receive a confirmation email shortly.');
        }
    }

    /**
     * Handle cancelled payment
     */
    public function cancel()
    {
        Log::info('User cancelled subscription checkout', [
            'agency_id' => Auth::user()->agency->id ?? 'unknown',
        ]);

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

        Log::info('Webhook received', [
            'has_signature' => !empty($sigHeader),
            'has_secret' => !empty($webhookSecret),
            'payload_length' => strlen($payload),
        ]);

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
            
            Log::info('Webhook event verified', [
                'event_type' => $event->type,
                'event_id' => $event->id,
            ]);

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
            Log::info('Processing checkout.session.completed', [
                'session_id' => $session->id,
                'subscription_id' => $session->subscription,
            ]);

            $agencyId = $session->metadata->agency_id ?? null;
            $planId = $session->metadata->plan_id ?? null;
            $billingCycle = $session->metadata->billing_cycle ?? 'monthly';

            if (!$agencyId || !$planId) {
                Log::error('Checkout completed: Missing metadata', [
                    'session_id' => $session->id,
                    'metadata' => $session->metadata,
                ]);
                return;
            }

            $agency = Agency::find($agencyId);
            $plan = SubscriptionPlan::find($planId);

            if (!$agency || !$plan) {
                Log::error('Checkout completed: Agency or Plan not found', [
                    'agency_id' => $agencyId,
                    'plan_id' => $planId,
                ]);
                return;
            }

            // Check if subscription already exists
            $existingSubscription = Subscription::where('stripe_subscription_id', $session->subscription)->first();
            if ($existingSubscription) {
                Log::info('Subscription already exists', [
                    'subscription_id' => $existingSubscription->id,
                ]);
                return;
            }

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

            Log::info('Subscription created', [
                'subscription_id' => $subscription->id,
                'agency_id' => $agency->id,
            ]);

            // Update agency status to active
            $agency->update([
                'status' => 'active',
                'subscription_id' => $subscription->id,
            ]);

            Log::info('Agency activated', [
                'agency_id' => $agency->id,
            ]);

            // Update pending transaction
            Transaction::where('stripe_payment_id', $session->id)->update([
                'status' => 'completed',
                'paid_at' => now(),
                'subscription_id' => $subscription->id,
            ]);

            // Create initial transaction record
            $amount = $session->amount_total / 100;
            Transaction::create([
                'agency_id' => $agency->id,
                'subscription_plan_id' => $plan->id,
                'subscription_id' => $subscription->id,
                'stripe_payment_id' => $session->payment_intent,
                'amount' => $amount,
                'currency' => strtoupper($session->currency),
                'status' => 'completed',
                'type' => 'subscription',
                'billing_cycle' => $billingCycle,
                'paid_at' => now(),
                'metadata' => json_encode([
                    'session_id' => $session->id,
                    'customer_id' => $session->customer,
                    'plan_name' => $plan->name,
                ]),
            ]);

            Log::info('Subscription activation complete', [
                'agency_id' => $agency->id,
                'subscription_id' => $subscription->id,
                'plan_name' => $plan->name,
            ]);

            // TODO: Send welcome email

        } catch (\Exception $e) {
            Log::error('Checkout completed webhook error: ' . $e->getMessage(), [
                'session_id' => $session->id ?? 'unknown',
                'error_type' => get_class($e),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Handle successful payment
     */
    protected function handlePaymentSucceeded($invoice)
    {
        try {
            Log::info('Processing invoice.payment_succeeded', [
                'invoice_id' => $invoice->id,
                'subscription_id' => $invoice->subscription,
            ]);

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
            } else {
                Log::warning('Payment succeeded but subscription not found', [
                    'stripe_subscription_id' => $invoice->subscription,
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Payment succeeded webhook error: ' . $e->getMessage(), [
                'invoice_id' => $invoice->id ?? 'unknown',
            ]);
        }
    }

    /**
     * Handle failed payment
     */
    protected function handlePaymentFailed($invoice)
    {
        try {
            Log::warning('Processing invoice.payment_failed', [
                'invoice_id' => $invoice->id,
                'subscription_id' => $invoice->subscription,
            ]);

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

                Log::warning('Payment failed recorded', [
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
            Log::info('Processing customer.subscription.deleted', [
                'stripe_subscription_id' => $stripeSubscription->id,
            ]);

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
                    'agency_id' => $subscription->agency_id,
                ]);

                // TODO: Send subscription cancelled email
            }

        } catch (\Exception $e) {
            Log::error('Subscription deleted webhook error: ' . $e->getMessage());
        }
    }
}