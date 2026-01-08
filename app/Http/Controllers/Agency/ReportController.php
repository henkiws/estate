<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyApplication;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display reports dashboard
     */
    public function index()
    {
        $agency = auth()->user()->agency;
        
        if (!$agency) {
            return redirect()->route('agency.dashboard')
                ->with('error', 'No agency found for your account.');
        }

        // Overview statistics
        $stats = [
            'total_properties' => Property::where('agency_id', $agency->id)->count(),
            'active_properties' => Property::where('agency_id', $agency->id)->where('status', 'active')->count(),
            'total_applications' => PropertyApplication::where('agency_id', $agency->id)->count(),
            'pending_applications' => PropertyApplication::where('agency_id', $agency->id)->where('status', 'pending')->count(),
            'approved_applications' => PropertyApplication::where('agency_id', $agency->id)->where('status', 'approved')->count(),
            'total_tenants' => Tenant::where('agency_id', $agency->id)->count(),
            'active_tenants' => Tenant::where('agency_id', $agency->id)->where('status', 'active')->count(),
        ];

        // Monthly trends (last 12 months)
        $monthlyApplications = PropertyApplication::where('agency_id', $agency->id)
            ->where('submitted_at', '>=', now()->subMonths(12))
            ->selectRaw('DATE_FORMAT(submitted_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyTenants = Tenant::where('agency_id', $agency->id)
            ->where('created_at', '>=', now()->subMonths(12))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Property performance
        $propertyPerformance = Property::where('agency_id', $agency->id)
            ->withCount('applications')
            ->orderByDesc('applications_count')
            ->limit(5)
            ->get();

        // Application status breakdown
        $applicationsByStatus = PropertyApplication::where('agency_id', $agency->id)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Tenant status breakdown
        $tenantsByStatus = Tenant::where('agency_id', $agency->id)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        return view('agency.reports.index', compact(
            'stats',
            'monthlyApplications',
            'monthlyTenants',
            'propertyPerformance',
            'applicationsByStatus',
            'tenantsByStatus'
        ));
    }

    /**
     * Properties report
     */
    public function properties(Request $request)
    {
        $agency = auth()->user()->agency;
        
        if (!$agency) {
            return redirect()->route('agency.dashboard')
                ->with('error', 'No agency found for your account.');
        }

        $query = Property::where('agency_id', $agency->id)
            ->withCount(['applications', 'enquiries']);

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Property type filter
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        $properties = $query->latest()->paginate(20)->appends($request->except('page'));

        // Statistics
        $stats = [
            'total' => Property::where('agency_id', $agency->id)->count(),
            'active' => Property::where('agency_id', $agency->id)->where('status', 'active')->count(),
            'rented' => Property::where('agency_id', $agency->id)->where('status', 'rented')->count(),
            'draft' => Property::where('agency_id', $agency->id)->where('status', 'draft')->count(),
            'total_applications' => PropertyApplication::where('agency_id', $agency->id)->count(),
            'total_enquiries' => Property::where('agency_id', $agency->id)->sum('enquiry_count'),
            'avg_rent' => Property::where('agency_id', $agency->id)
                ->where('rent_per_week', '>', 0)
                ->avg('rent_per_week'),
        ];

        // Properties by type
        $propertiesByType = Property::where('agency_id', $agency->id)
            ->selectRaw('property_type, COUNT(*) as count')
            ->groupBy('property_type')
            ->get()
            ->pluck('count', 'property_type');

        return view('agency.reports.properties', compact('properties', 'stats', 'propertiesByType'));
    }

    /**
     * Applications report
     */
    public function applications(Request $request)
    {
        $agency = auth()->user()->agency;
        
        if (!$agency) {
            return redirect()->route('agency.dashboard')
                ->with('error', 'No agency found for your account.');
        }

        $query = PropertyApplication::where('agency_id', $agency->id)
            ->with(['user', 'property']);

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest('submitted_at')->paginate(20)->appends($request->except('page'));

        // Statistics
        $stats = [
            'total' => PropertyApplication::where('agency_id', $agency->id)->count(),
            'pending' => PropertyApplication::where('agency_id', $agency->id)->where('status', 'pending')->count(),
            'under_review' => PropertyApplication::where('agency_id', $agency->id)->where('status', 'under_review')->count(),
            'approved' => PropertyApplication::where('agency_id', $agency->id)->where('status', 'approved')->count(),
            'rejected' => PropertyApplication::where('agency_id', $agency->id)->where('status', 'rejected')->count(),
            'this_month' => PropertyApplication::where('agency_id', $agency->id)
                ->whereMonth('submitted_at', now()->month)
                ->count(),
            'avg_response_time' => $this->calculateAverageResponseTime($agency->id),
        ];

        // Applications by month (last 6 months)
        $applicationsByMonth = PropertyApplication::where('agency_id', $agency->id)
            ->where('submitted_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(submitted_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('agency.reports.applications', compact('applications', 'stats', 'applicationsByMonth'));
    }

    /**
     * Tenants report
     */
    public function tenants(Request $request)
    {
        $agency = auth()->user()->agency;
        
        if (!$agency) {
            return redirect()->route('agency.dashboard')
                ->with('error', 'No agency found for your account.');
        }

        $query = Tenant::where('agency_id', $agency->id)
            ->with(['user', 'property']);

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('lease_start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('lease_start_date', '<=', $request->date_to);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tenants = $query->latest()->paginate(20)->appends($request->except('page'));

        // Statistics
        $stats = [
            'total' => Tenant::where('agency_id', $agency->id)->count(),
            'active' => Tenant::where('agency_id', $agency->id)->where('status', 'active')->count(),
            'pending_move_in' => Tenant::where('agency_id', $agency->id)->where('status', 'pending_move_in')->count(),
            'notice_given' => Tenant::where('agency_id', $agency->id)->where('status', 'notice_given')->count(),
            'ending' => Tenant::where('agency_id', $agency->id)->where('status', 'ending')->count(),
            'expiring_soon' => Tenant::where('agency_id', $agency->id)
                ->where('status', 'active')
                ->whereBetween('lease_end_date', [now(), now()->addDays(60)])
                ->count(),
            'total_rent' => Tenant::where('agency_id', $agency->id)
                ->where('status', 'active')
                ->sum('rent_amount'),
        ];

        // Tenants by status
        $tenantsByStatus = Tenant::where('agency_id', $agency->id)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        return view('agency.reports.tenants', compact('tenants', 'stats', 'tenantsByStatus'));
    }

    /**
     * Financial report
     */
    public function financial(Request $request)
    {
        $agency = auth()->user()->agency;
        
        if (!$agency) {
            return redirect()->route('agency.dashboard')
                ->with('error', 'No agency found for your account.');
        }

        // Date range (default to current month)
        $dateFrom = $request->filled('date_from') ? $request->date_from : now()->startOfMonth()->toDateString();
        $dateTo = $request->filled('date_to') ? $request->date_to : now()->endOfMonth()->toDateString();

        // Active tenants with rent details
        $activeTenants = Tenant::where('agency_id', $agency->id)
            ->where('status', 'active')
            ->with('property')
            ->get();

        // Calculate expected monthly income
        $expectedIncome = $activeTenants->sum(function($tenant) {
            return match($tenant->payment_frequency) {
                'weekly' => $tenant->rent_amount * 4.33, // Average weeks per month
                'fortnightly' => $tenant->rent_amount * 2.165,
                'monthly' => $tenant->rent_amount,
                default => 0,
            };
        });

        // Bond statistics
        $bondStats = [
            'total_bonds' => Tenant::where('agency_id', $agency->id)
                ->whereIn('status', ['pending_move_in', 'active'])
                ->sum('bond_amount'),
            'bonds_paid' => Tenant::where('agency_id', $agency->id)
                ->whereIn('status', ['pending_move_in', 'active'])
                ->where('bond_paid', true)
                ->sum('bond_amount'),
            'bonds_unpaid' => Tenant::where('agency_id', $agency->id)
                ->whereIn('status', ['pending_move_in', 'active'])
                ->where('bond_paid', false)
                ->sum('bond_amount'),
        ];

        // Statistics
        $stats = [
            'expected_monthly_income' => $expectedIncome,
            'active_tenants_count' => $activeTenants->count(),
            'total_properties_rented' => Property::where('agency_id', $agency->id)
                ->whereHas('activeTenant')
                ->count(),
            'vacancy_rate' => $this->calculateVacancyRate($agency->id),
            'avg_rent_per_property' => $activeTenants->avg('rent_amount') ?? 0,
        ];

        // Income by property
        $incomeByProperty = $activeTenants->map(function($tenant) {
            $monthlyRent = match($tenant->payment_frequency) {
                'weekly' => $tenant->rent_amount * 4.33,
                'fortnightly' => $tenant->rent_amount * 2.165,
                'monthly' => $tenant->rent_amount,
                default => 0,
            };
            
            return [
                'property' => $tenant->property->headline ?? $tenant->property->short_address,
                'tenant' => $tenant->full_name,
                'rent' => $monthlyRent,
                'payment_frequency' => $tenant->payment_frequency,
            ];
        })->sortByDesc('rent')->take(10);

        return view('agency.reports.financial', compact(
            'stats',
            'bondStats',
            'activeTenants',
            'incomeByProperty',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Export report data
     */
    public function export(Request $request)
    {
        $reportType = $request->input('report_type');
        $format = $request->input('format', 'csv');

        // This is a placeholder - you can implement actual export functionality
        return back()->with('info', 'Export functionality will be available soon.');
    }

    /**
     * Calculate average response time for applications
     */
    private function calculateAverageResponseTime($agencyId)
    {
        $applications = PropertyApplication::where('agency_id', $agencyId)
            ->whereNotNull('reviewed_at')
            ->whereNotNull('submitted_at')
            ->get();

        if ($applications->isEmpty()) {
            return 0;
        }

        $totalHours = $applications->sum(function($app) {
            return $app->submitted_at->diffInHours($app->reviewed_at);
        });

        return round($totalHours / $applications->count(), 1);
    }

    /**
     * Calculate vacancy rate
     */
    private function calculateVacancyRate($agencyId)
    {
        $totalProperties = Property::where('agency_id', $agencyId)->count();
        
        if ($totalProperties === 0) {
            return 0;
        }

        $rentedProperties = Property::where('agency_id', $agencyId)
            ->whereHas('activeTenant')
            ->count();

        $vacantProperties = $totalProperties - $rentedProperties;

        return round(($vacantProperties / $totalProperties) * 100, 1);
    }
}