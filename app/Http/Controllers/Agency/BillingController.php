<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class BillingController extends Controller
{
    /**
     * Display billing and subscription history
     */
    public function index(Request $request)
    {
        $agency = Auth::user()->agency;
        
        // Get current subscription
        $subscription = $agency->subscription()
            ->with('plan')
            ->first();
        
        // Get transaction history with filters
        $query = Transaction::where('agency_id', $agency->id)
            ->with(['subscription.plan'])
            ->latest();
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $transactions = $query->paginate(15);
        
        // Calculate statistics
        $stats = [
            'total_spent' => Transaction::where('agency_id', $agency->id)
                ->where('status', 'completed')
                ->sum('amount'),
            'total_transactions' => Transaction::where('agency_id', $agency->id)->count(),
            'successful_transactions' => Transaction::where('agency_id', $agency->id)
                ->where('status', 'completed')
                ->count(),
            'failed_transactions' => Transaction::where('agency_id', $agency->id)
                ->where('status', 'failed')
                ->count(),
        ];
        
        // Get billing information
        $billing = $agency->billing;
        
        return view('agency.billing.index', compact(
            'subscription',
            'transactions',
            'stats',
            'billing'
        ));
    }
    
    /**
     * Download invoice for a transaction
     */
    public function downloadInvoice($transactionId)
    {
        $agency = Auth::user()->agency;
        
        $transaction = Transaction::where('agency_id', $agency->id)
            ->where('id', $transactionId)
            ->firstOrFail();
        
        // If Stripe invoice exists, redirect to Stripe invoice URL
        if ($transaction->stripe_invoice_id) {
            // You can implement Stripe invoice download here
            // For now, we'll return a JSON response
            return response()->json([
                'message' => 'Invoice download will be implemented with Stripe API',
                'stripe_invoice_id' => $transaction->stripe_invoice_id
            ]);
        }
        
        return response()->json([
            'error' => 'Invoice not available'
        ], 404);
    }
}