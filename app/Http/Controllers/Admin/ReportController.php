<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Property;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display the reports dashboard.
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    /**
     * Agencies report with analytics.
     */
    public function agencies(Request $request)
    {
        // Get date range from request or default to last 30 days
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // Overall statistics
        $stats = [
            'total_agencies' => Agency::count(),
            'approved_agencies' => Agency::where('status', 'approved')->count(),
            'pending_agencies' => Agency::where('status', 'pending')->count(),
            'rejected_agencies' => Agency::where('status', 'rejected')->count(),
            'suspended_agencies' => Agency::where('status', 'suspended')->count(),
            'new_this_month' => Agency::whereMonth('created_at', now()->month)->count(),
            'with_subscriptions' => Agency::has('subscription')->count(),
        ];

        // Agencies by state
        $agenciesByState = Agency::select('state', DB::raw('count(*) as count'))
            ->groupBy('state')
            ->orderByDesc('count')
            ->get();

        // Registration trend (last 12 months)
        $registrationTrend = Agency::whereBetween('created_at', [now()->subMonths(12), now()])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Approval rate by month
        $approvalRate = Agency::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('
                DATE_FORMAT(created_at, "%Y-%m") as month,
                SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected,
                COUNT(*) as total
            ')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top agencies by properties
        $topAgenciesByProperties = Agency::withCount('properties')
            ->orderByDesc('properties_count')
            ->take(10)
            ->get();

        // Recent agencies
        $recentAgencies = Agency::with('subscription.plan')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports.agencies', compact(
            'stats',
            'agenciesByState',
            'registrationTrend',
            'approvalRate',
            'topAgenciesByProperties',
            'recentAgencies',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Properties report with analytics.
     */
    public function properties(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // Overall statistics
        $stats = [
            'total_properties' => Property::count(),
            'for_sale' => Property::where('listing_type', 'sale')->count(),
            'for_rent' => Property::where('listing_type', 'rent')->count(),
            'both' => Property::where('listing_type', 'both')->count(),
            'featured' => Property::where('is_featured', true)->count(),
            'verified' => Property::where('is_verified', true)->count(),
            'new_this_month' => Property::whereMonth('created_at', now()->month)->count(),
        ];

        // Properties by type
        $propertiesByType = Property::select('property_type', DB::raw('count(*) as count'))
            ->groupBy('property_type')
            ->orderByDesc('count')
            ->get();

        // Properties by state
        $propertiesByState = Property::select('state', DB::raw('count(*) as count'))
            ->groupBy('state')
            ->orderByDesc('count')
            ->get();

        // Average prices
        $averagePrices = [
            'sale' => Property::where('listing_type', 'sale')
                ->whereNotNull('sale_price')
                ->avg('sale_price'),
            'rent' => Property::where('listing_type', 'rent')
                ->whereNotNull('rental_price_monthly')
                ->avg('rental_price_monthly'),
        ];

        // Listing trend (last 12 months)
        $listingTrend = Property::whereBetween('created_at', [now()->subMonths(12), now()])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top agencies by properties
        $topAgencies = Agency::withCount('properties')
            ->having('properties_count', '>', 0)
            ->orderByDesc('properties_count')
            ->take(10)
            ->get();

        // Recent properties
        $recentProperties = Property::with('agency')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports.properties', compact(
            'stats',
            'propertiesByType',
            'propertiesByState',
            'averagePrices',
            'listingTrend',
            'topAgencies',
            'recentProperties',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Users report with analytics.
     */
    public function users(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // Overall statistics
        $stats = [
            'total_users' => User::count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'admin_users' => User::where('is_admin', true)->count(),
            'users_with_agency' => User::whereNotNull('agency_id')->count(),
            'new_this_month' => User::whereMonth('created_at', now()->month)->count(),
        ];

        // Users by role
        $usersByRole = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('roles.name', DB::raw('count(*) as count'))
            ->groupBy('roles.name')
            ->get();

        // Registration trend (last 12 months)
        $registrationTrend = User::whereBetween('created_at', [now()->subMonths(12), now()])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Verification rate
        $verificationRate = User::selectRaw('
            SUM(CASE WHEN email_verified_at IS NOT NULL THEN 1 ELSE 0 END) as verified,
            SUM(CASE WHEN email_verified_at IS NULL THEN 1 ELSE 0 END) as unverified,
            COUNT(*) as total
        ')->first();

        // Recent users
        $recentUsers = User::with(['roles', 'agency'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports.users', compact(
            'stats',
            'usersByRole',
            'registrationTrend',
            'verificationRate',
            'recentUsers',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Revenue report with financial analytics.
     */
    public function revenue(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // Overall statistics
        $stats = [
            'total_revenue' => Transaction::where('status', 'completed')->sum('amount'),
            'this_month_revenue' => Transaction::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
            'last_month_revenue' => Transaction::where('status', 'completed')
                ->whereMonth('created_at', now()->subMonth()->month)
                ->sum('amount'),
            'average_transaction' => Transaction::where('status', 'completed')->avg('amount'),
            'total_transactions' => Transaction::where('status', 'completed')->count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'mrr' => $this->calculateMRR(),
            'arr' => $this->calculateARR(),
        ];

        // Revenue trend (last 12 months)
        $revenueTrend = Transaction::where('status', 'completed')
            ->whereBetween('created_at', [now()->subMonths(12), now()])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Revenue by plan
        $revenueByPlan = Transaction::where('transactions.status', 'completed')
            ->join('subscriptions', 'transactions.subscription_id', '=', 'subscriptions.id')
            ->join('subscription_plans', 'subscriptions.subscription_plan_id', '=', 'subscription_plans.id')
            ->selectRaw('subscription_plans.name, SUM(transactions.amount) as revenue')
            ->groupBy('subscription_plans.name')
            ->get();

        // Top revenue agencies
        $topRevenueAgencies = Transaction::where('status', 'completed')
            ->select('agency_id', DB::raw('SUM(amount) as total_revenue'))
            ->groupBy('agency_id')
            ->orderByDesc('total_revenue')
            ->with('agency')
            ->take(10)
            ->get();

        return view('admin.reports.revenue', compact(
            'stats',
            'revenueTrend',
            'revenueByPlan',
            'topRevenueAgencies',
            'startDate',
            'endDate'
        ));
    }

    /**
     * System overview report.
     */
    public function overview(Request $request)
    {
        $period = $request->input('period', '30'); // days

        $stats = [
            'agencies' => [
                'total' => Agency::count(),
                'new' => Agency::where('created_at', '>=', now()->subDays($period))->count(),
                'approved' => Agency::where('status', 'approved')->count(),
                'pending' => Agency::where('status', 'pending')->count(),
            ],
            'properties' => [
                'total' => Property::count(),
                'new' => Property::where('created_at', '>=', now()->subDays($period))->count(),
                'for_sale' => Property::where('listing_type', 'sale')->count(),
                'for_rent' => Property::where('listing_type', 'rent')->count(),
            ],
            'users' => [
                'total' => User::count(),
                'new' => User::where('created_at', '>=', now()->subDays($period))->count(),
                'verified' => User::whereNotNull('email_verified_at')->count(),
            ],
            'revenue' => [
                'total' => Transaction::where('status', 'completed')->sum('amount'),
                'this_period' => Transaction::where('status', 'completed')
                    ->where('created_at', '>=', now()->subDays($period))
                    ->sum('amount'),
                'active_subscriptions' => Subscription::where('status', 'active')->count(),
            ],
        ];

        // Activity timeline
        $activityTimeline = $this->getActivityTimeline($period);

        return view('admin.reports.overview', compact('stats', 'period', 'activityTimeline'));
    }

    /**
     * Export report data to CSV.
     */
    public function export(Request $request)
    {
        $type = $request->input('type', 'agencies');
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $filename = "report_{$type}_" . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($type, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            switch ($type) {
                case 'agencies':
                    $this->exportAgencies($file, $startDate, $endDate);
                    break;
                case 'properties':
                    $this->exportProperties($file, $startDate, $endDate);
                    break;
                case 'users':
                    $this->exportUsers($file, $startDate, $endDate);
                    break;
                case 'revenue':
                    $this->exportRevenue($file, $startDate, $endDate);
                    break;
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Private helper methods

    private function calculateMRR()
    {
        return Subscription::where('status', 'active')
            ->join('subscription_plans', 'subscriptions.subscription_plan_id', '=', 'subscription_plans.id')
            ->sum('subscription_plans.price');
    }

    private function calculateARR()
    {
        return $this->calculateMRR() * 12;
    }

    private function getActivityTimeline($days)
    {
        return [
            'agencies' => Agency::where('created_at', '>=', now()->subDays($days))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            'properties' => Property::where('created_at', '>=', now()->subDays($days))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            'users' => User::where('created_at', '>=', now()->subDays($days))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
        ];
    }

    private function exportAgencies($file, $startDate, $endDate)
    {
        fputcsv($file, ['ID', 'Agency Name', 'License Number', 'State', 'Status', 'Properties Count', 'Created At']);
        
        Agency::withCount('properties')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->chunk(100, function ($agencies) use ($file) {
                foreach ($agencies as $agency) {
                    fputcsv($file, [
                        $agency->id,
                        $agency->agency_name,
                        $agency->license_number,
                        $agency->state,
                        $agency->status,
                        $agency->properties_count,
                        $agency->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
    }

    private function exportProperties($file, $startDate, $endDate)
    {
        fputcsv($file, ['ID', 'Title', 'Type', 'Listing Type', 'State', 'Agency', 'Price', 'Created At']);
        
        Property::with('agency')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->chunk(100, function ($properties) use ($file) {
                foreach ($properties as $property) {
                    fputcsv($file, [
                        $property->id,
                        $property->title,
                        $property->property_type,
                        $property->listing_type,
                        $property->state,
                        $property->agency->agency_name ?? 'N/A',
                        $property->sale_price ?? $property->rental_price_monthly,
                        $property->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
    }

    private function exportUsers($file, $startDate, $endDate)
    {
        fputcsv($file, ['ID', 'Name', 'Email', 'Role', 'Agency', 'Verified', 'Created At']);
        
        User::with(['roles', 'agency'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->chunk(100, function ($users) use ($file) {
                foreach ($users as $user) {
                    fputcsv($file, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->roles->pluck('name')->implode(', '),
                        $user->agency->agency_name ?? 'N/A',
                        $user->email_verified_at ? 'Yes' : 'No',
                        $user->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
    }

    private function exportRevenue($file, $startDate, $endDate)
    {
        fputcsv($file, ['Transaction ID', 'Agency', 'Amount', 'Type', 'Status', 'Date']);
        
        Transaction::with('agency')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->chunk(100, function ($transactions) use ($file) {
                foreach ($transactions as $transaction) {
                    fputcsv($file, [
                        $transaction->transaction_id ?? $transaction->id,
                        $transaction->agency->agency_name ?? 'N/A',
                        $transaction->amount,
                        $transaction->type,
                        $transaction->status,
                        $transaction->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
    }
}