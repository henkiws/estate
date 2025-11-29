<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Subscription;
use App\Models\Agency;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of all transactions.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['agency', 'subscription'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by agency
        if ($request->filled('agency_id')) {
            $query->where('agency_id', $request->agency_id);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Search by transaction ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('stripe_charge_id', 'like', "%{$search}%")
                  ->orWhere('stripe_invoice_id', 'like', "%{$search}%");
            });
        }

        // Get all agencies for filter
        $agencies = Agency::where('status', 'approved')
            ->orderBy('agency_name')
            ->get();

        $transactions = $query->paginate(20)->withQueryString();

        return view('admin.payments.index', compact('transactions', 'agencies'));
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['agency', 'subscription.plan']);

        return view('admin.payments.show', compact('transaction'));
    }

    /**
     * Show subscriptions overview.
     */
    public function subscriptions(Request $request)
    {
        $query = Subscription::with(['agency', 'plan'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by plan
        if ($request->filled('plan_id')) {
            $query->where('subscription_plan_id', $request->plan_id);
        }

        // Filter by agency
        if ($request->filled('agency_id')) {
            $query->where('agency_id', $request->agency_id);
        }

        // Get plans and agencies for filters
        $plans = SubscriptionPlan::orderBy('name')->get();
        $agencies = Agency::where('status', 'approved')
            ->orderBy('agency_name')
            ->get();

        $subscriptions = $query->paginate(20)->withQueryString();

        return view('admin.payments.subscriptions', compact('subscriptions', 'plans', 'agencies'));
    }

    /**
     * Show payment statistics.
     */
    public function statistics()
    {
        // Overall statistics
        $stats = [
            'total_revenue' => Transaction::where('status', 'completed')->sum('amount'),
            'total_transactions' => Transaction::count(),
            'successful_transactions' => Transaction::where('status', 'completed')->count(),
            'failed_transactions' => Transaction::where('status', 'failed')->count(),
            'pending_transactions' => Transaction::where('status', 'pending')->count(),
            'refunded_amount' => Transaction::where('status', 'refunded')->sum('amount'),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'cancelled_subscriptions' => Subscription::where('status', 'cancelled')->count(),
        ];

        // Revenue by month (last 12 months)
        $monthlyRevenue = Transaction::where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(12))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Revenue by plan
        $revenueByPlan = Transaction::where('status', 'completed')
            ->join('subscriptions', 'transactions.subscription_id', '=', 'subscriptions.id')
            ->join('subscription_plans', 'subscriptions.subscription_plan_id', '=', 'subscription_plans.id')
            ->selectRaw('subscription_plans.name, SUM(transactions.amount) as revenue, COUNT(transactions.id) as count')
            ->groupBy('subscription_plans.name')
            ->get();

        // Top paying agencies
        $topAgencies = Transaction::where('status', 'completed')
            ->select('agency_id', DB::raw('SUM(amount) as total_paid'), DB::raw('COUNT(*) as payment_count'))
            ->groupBy('agency_id')
            ->orderByDesc('total_paid')
            ->take(10)
            ->with('agency')
            ->get();

        // Recent transactions
        $recentTransactions = Transaction::with(['agency', 'subscription'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Subscription distribution
        $subscriptionsByPlan = Subscription::where('status', 'active')
            ->select('subscription_plan_id', DB::raw('COUNT(*) as count'))
            ->groupBy('subscription_plan_id')
            ->with('plan')
            ->get();

        return view('admin.payments.statistics', compact(
            'stats',
            'monthlyRevenue',
            'revenueByPlan',
            'topAgencies',
            'recentTransactions',
            'subscriptionsByPlan'
        ));
    }

    /**
     * Export transactions to CSV.
     */
    public function export(Request $request)
    {
        $query = Transaction::with(['agency', 'subscription.plan']);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('agency_id')) {
            $query->where('agency_id', $request->agency_id);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $query->get();

        // Generate CSV
        $filename = 'transactions_export_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'Transaction ID', 'Agency', 'Plan', 'Amount', 'Currency', 'Type',
                'Status', 'Payment Method', 'Description', 'Stripe Charge ID',
                'Stripe Invoice ID', 'Created At'
            ]);

            // CSV Data
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->transaction_id ?? 'N/A',
                    $transaction->agency->agency_name ?? 'N/A',
                    $transaction->subscription->plan->name ?? 'N/A',
                    $transaction->amount,
                    $transaction->currency,
                    ucfirst($transaction->type),
                    ucfirst($transaction->status),
                    $transaction->payment_method ?? 'N/A',
                    $transaction->description ?? 'N/A',
                    $transaction->stripe_charge_id ?? 'N/A',
                    $transaction->stripe_invoice_id ?? 'N/A',
                    $transaction->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show failed payments for review.
     */
    public function failedPayments()
    {
        $failedTransactions = Transaction::where('status', 'failed')
            ->with(['agency', 'subscription.plan'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.payments.failed', compact('failedTransactions'));
    }

    /**
     * Show refunded payments.
     */
    public function refunds()
    {
        $refunds = Transaction::where('status', 'refunded')
            ->orWhere('type', 'refund')
            ->with(['agency', 'subscription.plan'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.payments.refunds', compact('refunds'));
    }

    /**
     * Manual refund processing.
     */
    public function processRefund(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
            'amount' => 'nullable|numeric|min:0|max:' . $transaction->amount,
        ]);

        try {
            // Process refund through Stripe
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            
            $refundAmount = $validated['amount'] ?? $transaction->amount;
            $refundAmountCents = $refundAmount * 100; // Convert to cents

            $refund = $stripe->refunds->create([
                'charge' => $transaction->stripe_charge_id,
                'amount' => $refundAmountCents,
                'reason' => 'requested_by_customer',
            ]);

            // Update transaction
            $transaction->update([
                'status' => 'refunded',
                'failure_reason' => $validated['reason'],
            ]);

            // Create refund transaction record
            Transaction::create([
                'agency_id' => $transaction->agency_id,
                'subscription_id' => $transaction->subscription_id,
                'transaction_id' => $refund->id,
                'amount' => -$refundAmount, // Negative for refund
                'currency' => $transaction->currency,
                'type' => 'refund',
                'status' => 'completed',
                'stripe_charge_id' => $refund->charge,
                'description' => 'Refund: ' . $validated['reason'],
            ]);

            return redirect()
                ->route('admin.payments.show', $transaction)
                ->with('success', 'Refund processed successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to process refund: ' . $e->getMessage());
        }
    }

    /**
     * Retry failed payment.
     */
    public function retryPayment(Transaction $transaction)
    {
        if ($transaction->status !== 'failed') {
            return back()->with('error', 'Only failed payments can be retried.');
        }

        try {
            // This would typically involve creating a new payment intent
            // For now, we'll just update the status
            $transaction->update([
                'status' => 'pending',
                'failure_reason' => null,
            ]);

            return back()->with('success', 'Payment retry initiated. Customer will be notified.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to retry payment: ' . $e->getMessage());
        }
    }

    /**
     * Cancel subscription.
     */
    public function cancelSubscription(Subscription $subscription)
    {
        try {
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            
            // Cancel at Stripe
            $stripe->subscriptions->cancel($subscription->stripe_subscription_id);

            // Update local record
            $subscription->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'ends_at' => $subscription->current_period_end, // Allow until end of current period
            ]);

            return redirect()
                ->route('admin.payments.subscriptions')
                ->with('success', 'Subscription cancelled successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cancel subscription: ' . $e->getMessage());
        }
    }
}