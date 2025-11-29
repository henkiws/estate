<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::with(['roles', 'agency']);

        // Filter by role
        if ($request->filled('role')) {
            $query->role($request->role);
        }

        // Filter by agency
        if ($request->filled('agency_id')) {
            $query->where('agency_id', $request->agency_id);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status (active/inactive)
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNull('email_verified_at');
            }
        }

        // Get all roles and agencies for filters
        $roles = Role::orderBy('name')->get();
        $agencies = Agency::where('status', 'approved')
            ->orderBy('agency_name')
            ->get();

        $users = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'roles', 'agencies'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::orderBy('name')->get();
        $agencies = Agency::where('status', 'approved')
            ->orderBy('agency_name')
            ->get();

        return view('admin.users.create', compact('roles', 'agencies'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|exists:roles,name',
            'agency_id' => 'nullable|exists:agencies,id',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'agency_id' => $validated['agency_id'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'position' => $validated['position'] ?? null,
            'email_verified_at' => now(), // Auto-verify admin-created users
        ]);

        // Assign role
        $user->assignRole($validated['role']);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load(['roles', 'permissions', 'agency']);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        $agencies = Agency::where('status', 'approved')
            ->orderBy('agency_name')
            ->get();

        return view('admin.users.edit', compact('user', 'roles', 'agencies'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'role' => 'required|exists:roles,name',
            'agency_id' => 'nullable|exists:agencies,id',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'is_admin' => 'boolean',
        ]);

        // Update user data
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'agency_id' => $validated['agency_id'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'position' => $validated['position'] ?? null,
            'is_admin' => $request->has('is_admin') ? true : false,
        ]);

        // Update password if provided
        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        // Sync role
        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user admin status.
     */
    public function toggleAdmin(User $user)
    {
        // Prevent removing own admin status
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot remove your own admin status.');
        }

        $user->update([
            'is_admin' => !$user->is_admin
        ]);

        return back()->with('success', 'Admin status updated successfully.');
    }

    /**
     * Verify user email.
     */
    public function verifyEmail(User $user)
    {
        if ($user->email_verified_at) {
            return back()->with('info', 'Email is already verified.');
        }

        $user->update([
            'email_verified_at' => now()
        ]);

        return back()->with('success', 'User email verified successfully.');
    }

    /**
     * Suspend/unsuspend user.
     */
    public function toggleStatus(User $user)
    {
        // Prevent self-suspension
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        if ($user->email_verified_at) {
            // Suspend (remove verification)
            $user->update(['email_verified_at' => null]);
            $message = 'User suspended successfully.';
        } else {
            // Activate (add verification)
            $user->update(['email_verified_at' => now()]);
            $message = 'User activated successfully.';
        }

        return back()->with('success', $message);
    }

    /**
     * Bulk update users.
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'action' => 'required|in:verify,suspend,activate,delete,assign_role',
            'role' => 'required_if:action,assign_role|exists:roles,name',
        ]);

        $users = User::whereIn('id', $validated['user_ids']);

        // Prevent actions on self
        if (in_array(auth()->id(), $validated['user_ids'])) {
            return back()->with('error', 'Cannot perform bulk actions on your own account.');
        }

        switch ($validated['action']) {
            case 'verify':
                $users->update(['email_verified_at' => now()]);
                $message = 'Users verified successfully.';
                break;
            case 'suspend':
                $users->update(['email_verified_at' => null]);
                $message = 'Users suspended successfully.';
                break;
            case 'activate':
                $users->update(['email_verified_at' => now()]);
                $message = 'Users activated successfully.';
                break;
            case 'assign_role':
                foreach ($users->get() as $user) {
                    $user->syncRoles([$validated['role']]);
                }
                $message = 'Role assigned successfully.';
                break;
            case 'delete':
                $users->delete();
                $message = 'Users deleted successfully.';
                break;
        }

        return back()->with('success', $message);
    }

    /**
     * Export users data.
     */
    public function export(Request $request)
    {
        $query = User::with(['roles', 'agency']);

        // Apply same filters as index
        if ($request->filled('role')) {
            $query->role($request->role);
        }
        if ($request->filled('agency_id')) {
            $query->where('agency_id', $request->agency_id);
        }

        $users = $query->get();

        // Generate CSV
        $filename = 'users_export_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID', 'Name', 'Email', 'Role', 'Agency', 'Phone', 'Position',
                'Admin', 'Email Verified', 'Created At'
            ]);

            // CSV Data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->roles->pluck('name')->implode(', '),
                    $user->agency->agency_name ?? 'N/A',
                    $user->phone ?? 'N/A',
                    $user->position ?? 'N/A',
                    $user->is_admin ? 'Yes' : 'No',
                    $user->email_verified_at ? 'Yes' : 'No',
                    $user->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show statistics dashboard.
     */
    public function statistics()
    {
        $stats = [
            'total_users' => User::count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'admin_users' => User::where('is_admin', true)->count(),
            'users_with_agency' => User::whereNotNull('agency_id')->count(),
        ];

        // Users by role
        $usersByRole = Role::withCount('users')->get();

        // Recent users
        $recentUsers = User::with(['roles', 'agency'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Users by agency
        $usersByAgency = User::whereNotNull('agency_id')
            ->selectRaw('agency_id, count(*) as count')
            ->groupBy('agency_id')
            ->with('agency')
            ->get()
            ->map(function($item) {
                return [
                    'agency' => $item->agency->agency_name ?? 'Unknown',
                    'count' => $item->count
                ];
            });

        return view('admin.users.statistics', compact('stats', 'usersByRole', 'recentUsers', 'usersByAgency'));
    }
}