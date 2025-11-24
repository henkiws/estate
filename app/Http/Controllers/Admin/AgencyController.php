<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AgencyRepository;
use App\Mail\AgencyApproved;
use App\Mail\AgencyRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

class AgencyController extends Controller
{
    public function __construct(
        protected AgencyRepository $agencyRepository
    ) {}

    /**
     * Display a listing of agencies
     */
    public function index(Request $request)
    {
        $filters = [
            'status' => $request->get('status'),
            'state' => $request->get('state'),
            'search' => $request->get('search'),
        ];

        $agencies = $this->agencyRepository->getAllPaginated(15, array_filter($filters));
        $stats = $this->agencyRepository->getStatistics();
        $stateStats = $this->agencyRepository->getStatisticsByState();

        return view('admin.agencies.index', compact('agencies', 'stats', 'stateStats', 'filters'));
    }

    /**
     * Display the specified agency
     */
    public function show(int $id)
    {
        $agency = $this->agencyRepository->findWithAllRelations($id);

        if (!$agency) {
            return redirect()->route('admin.agencies.index')
                ->with('error', 'Agency not found.');
        }

        return view('admin.agencies.show', compact('agency'));
    }

    /**
     * Show the form for editing the specified agency
     */
    public function edit(int $id)
    {
        $agency = $this->agencyRepository->findWithAllRelations($id);

        if (!$agency) {
            return redirect()->route('admin.agencies.index')
                ->with('error', 'Agency not found.');
        }

        return view('admin.agencies.edit', compact('agency'));
    }

    /**
     * Update the specified agency
     */
    public function update(Request $request, int $id)
    {
        try {
            $this->agencyRepository->update($id, $request->all());

            Log::info('Agency updated by admin', [
                'agency_id' => $id,
                'admin_id' => auth()->id(),
            ]);

            return redirect()->route('admin.agencies.show', $id)
                ->with('success', 'Agency updated successfully!');

        } catch (Exception $e) {
            Log::error('Failed to update agency', [
                'agency_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()
                ->with('error', 'Failed to update agency. Please try again.');
        }
    }

    /**
     * Approve the agency
     */
    public function approve(int $id)
    {
        try {
            $agency = $this->agencyRepository->findById($id, ['users']);

            if (!$agency) {
                return back()->with('error', 'Agency not found.');
            }

            if ($agency->status === 'active') {
                return back()->with('info', 'Agency is already approved.');
            }

            // Approve the agency
            $this->agencyRepository->approve($id, auth()->id());

            // Log the action
            Log::info('Agency approved', [
                'agency_id' => $id,
                'agency_name' => $agency->agency_name,
                'approved_by' => auth()->id(),
            ]);

            // Send approval email to agency
            try {
                $user = $agency->users()->first();
                if ($user) {
                    Mail::to($user->email)->send(new AgencyApproved($agency->fresh()));
                    Log::info('Approval email sent', ['email' => $user->email]);
                }
            } catch (Exception $e) {
                Log::error('Failed to send approval email', [
                    'error' => $e->getMessage(),
                    'agency_id' => $id,
                ]);
            }

            return back()->with('success', 'Agency approved successfully! Notification email sent.');

        } catch (Exception $e) {
            Log::error('Failed to approve agency', [
                'agency_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to approve agency. Please try again.');
        }
    }

    /**
     * Reject the agency
     */
    public function reject(Request $request, int $id)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:1000',
        ]);

        try {
            $agency = $this->agencyRepository->findById($id, ['users']);

            if (!$agency) {
                return back()->with('error', 'Agency not found.');
            }

            // Reject the agency
            $reason = $request->input('rejection_reason');
            $this->agencyRepository->reject($id, $reason);

            // Log the action
            Log::info('Agency rejected', [
                'agency_id' => $id,
                'agency_name' => $agency->agency_name,
                'rejected_by' => auth()->id(),
                'reason' => $reason,
            ]);

            // Send rejection email to agency
            try {
                $user = $agency->users()->first();
                if ($user) {
                    Mail::to($user->email)->send(new AgencyRejected($agency->fresh(), $reason));
                    Log::info('Rejection email sent', ['email' => $user->email]);
                }
            } catch (Exception $e) {
                Log::error('Failed to send rejection email', [
                    'error' => $e->getMessage(),
                    'agency_id' => $id,
                ]);
            }

            return back()->with('success', 'Agency rejected. Notification email sent.');

        } catch (Exception $e) {
            Log::error('Failed to reject agency', [
                'agency_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to reject agency. Please try again.');
        }
    }

    /**
     * Suspend the agency
     */
    public function suspend(Request $request, int $id)
    {
        $request->validate([
            'suspension_reason' => 'nullable|string|max:1000',
        ]);

        try {
            $agency = $this->agencyRepository->findById($id);

            if (!$agency) {
                return back()->with('error', 'Agency not found.');
            }

            $this->agencyRepository->updateStatus($id, 'suspended');

            Log::info('Agency suspended', [
                'agency_id' => $id,
                'suspended_by' => auth()->id(),
                'reason' => $request->input('suspension_reason'),
            ]);

            return back()->with('success', 'Agency suspended successfully.');

        } catch (Exception $e) {
            Log::error('Failed to suspend agency', [
                'agency_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to suspend agency. Please try again.');
        }
    }

    /**
     * Reactivate the agency
     */
    public function reactivate(int $id)
    {
        try {
            $agency = $this->agencyRepository->findById($id);

            if (!$agency) {
                return back()->with('error', 'Agency not found.');
            }

            $this->agencyRepository->updateStatus($id, 'active', auth()->id());

            Log::info('Agency reactivated', [
                'agency_id' => $id,
                'reactivated_by' => auth()->id(),
            ]);

            return back()->with('success', 'Agency reactivated successfully.');

        } catch (Exception $e) {
            Log::error('Failed to reactivate agency', [
                'agency_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to reactivate agency. Please try again.');
        }
    }

    /**
     * Remove the specified agency
     */
    public function destroy(int $id)
    {
        try {
            $agency = $this->agencyRepository->findById($id);

            if (!$agency) {
                return back()->with('error', 'Agency not found.');
            }

            $agencyName = $agency->agency_name;
            $this->agencyRepository->delete($id);

            Log::warning('Agency deleted', [
                'agency_id' => $id,
                'agency_name' => $agencyName,
                'deleted_by' => auth()->id(),
            ]);

            return redirect()->route('admin.agencies.index')
                ->with('success', 'Agency deleted successfully.');

        } catch (Exception $e) {
            Log::error('Failed to delete agency', [
                'agency_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to delete agency. Please try again.');
        }
    }

    /**
     * Get pending agencies count (for dashboard widget)
     */
    public function getPendingCount()
    {
        $count = $this->agencyRepository->getByStatus('pending', 1)->total();
        return response()->json(['count' => $count]);
    }
}