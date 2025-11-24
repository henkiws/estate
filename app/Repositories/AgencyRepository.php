<?php

namespace App\Repositories;

use App\Models\Agency;
use App\Models\AgencyContact;
use App\Models\AgencySetting;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Exception;

class AgencyRepository
{
    /**
     * Create a new agency with all related data
     */
    public function createAgency(array $data): Agency
    {
        try {
            DB::beginTransaction();

            // 1. Create Agency
            $agency = Agency::create([
                'agency_name' => $data['agency_name'],
                'trading_name' => $data['trading_name'] ?? null,
                'abn' => $this->cleanABN($data['abn']),
                'acn' => isset($data['acn']) ? $this->cleanACN($data['acn']) : null,
                'business_type' => $data['business_type'] ?? 'company',
                'license_number' => $data['license_number'],
                'license_holder_name' => $data['license_holder'],
                'license_expiry_date' => $data['license_expiry_date'] ?? null,
                'business_address' => $data['business_address'],
                'state' => $data['state'],
                'postcode' => $data['postcode'],
                'business_phone' => $data['business_phone'],
                'business_email' => $data['business_email'],
                'website_url' => $data['website'] ?? null,
                'status' => 'pending', // Default status
            ]);

            // 2. Create User Account (Agency Admin)
            $user = User::create([
                'name' => $data['license_holder'] ?? $data['agency_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['business_phone'],
                'position' => 'Principal/Licensee',
                'agency_id' => $agency->id,
            ]);

            // Assign 'agency' role using Spatie Permission
            $user->assignRole('agency');

            // 3. Create Primary Contact
            AgencyContact::create([
                'agency_id' => $agency->id,
                'user_id' => $user->id,
                'full_name' => $data['license_holder'],
                'position' => 'Principal/Licensee',
                'email' => $data['email'],
                'phone' => $data['business_phone'],
                'mobile' => $data['business_phone'],
                'is_primary' => true,
            ]);

            // 4. Create Agency Settings (Terms acceptance)
            AgencySetting::create([
                'agency_id' => $agency->id,
                'terms_accepted' => true,
                'terms_accepted_at' => now(),
                'terms_accepted_ip' => request()->ip(),
                'privacy_accepted' => true,
                'privacy_accepted_at' => now(),
                'privacy_accepted_ip' => request()->ip(),
            ]);

            // 5. Create empty related records
            $agency->branding()->create([]);
            $agency->services()->create([]);
            $agency->compliance()->create([]);
            
            // Only create billing if data is provided
            if (!empty($data['billing_contact_name'])) {
                $agency->billing()->create([
                    'billing_contact_name' => $data['billing_contact_name'],
                    'billing_email' => $data['billing_email'],
                    'billing_phone' => $data['billing_phone'],
                    'billing_address' => $data['billing_address'] ?? null,
                ]);
            }

            DB::commit();

            return $agency->load(['users', 'contacts', 'settings', 'branding', 'services']);

        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to create agency: " . $e->getMessage());
        }
    }

    /**
     * Find agency by ID with relations
     */
    public function findById(int $id, array $relations = []): ?Agency
    {
        $query = Agency::query();
        
        if (!empty($relations)) {
            $query->with($relations);
        }
        
        return $query->find($id);
    }

    /**
     * Find agency with all relations
     */
    public function findWithAllRelations(int $id): ?Agency
    {
        return Agency::with([
            'users',
            'contacts',
            'documents',
            'branding',
            'services',
            'billing',
            'compliance',
            'settings',
            'agents'
        ])->find($id);
    }

    /**
     * Find agency by ABN
     */
    public function findByABN(string $abn): ?Agency
    {
        return Agency::where('abn', $this->cleanABN($abn))->first();
    }

    /**
     * Find agency by license number
     */
    public function findByLicenseNumber(string $licenseNumber): ?Agency
    {
        return Agency::where('license_number', $licenseNumber)->first();
    }

    /**
     * Find agency by email
     */
    public function findByEmail(string $email): ?Agency
    {
        return Agency::where('business_email', $email)->first();
    }

    /**
     * Update agency information
     */
    public function update(int $id, array $data): bool
    {
        $agency = Agency::findOrFail($id);
        
        if (isset($data['abn'])) {
            $data['abn'] = $this->cleanABN($data['abn']);
        }
        
        if (isset($data['acn'])) {
            $data['acn'] = $this->cleanACN($data['acn']);
        }

        return $agency->update($data);
    }

    /**
     * Update agency status
     */
    public function updateStatus(int $id, string $status, ?int $verifiedBy = null): bool
    {
        $agency = Agency::findOrFail($id);
        
        $agency->status = $status;
        
        if ($status === 'active' && !$agency->verified_at) {
            $agency->verified_at = now();
            $agency->verified_by = $verifiedBy;
        }
        
        return $agency->save();
    }

    /**
     * Approve agency
     */
    public function approve(int $id, int $approvedBy): bool
    {
        return $this->updateStatus($id, 'active', $approvedBy);
    }

    /**
     * Reject agency
     */
    public function reject(int $id, string $reason = null): bool
    {
        $agency = Agency::findOrFail($id);
        $agency->status = 'inactive';
        return $agency->save();
    }

    /**
     * Add contact to agency
     */
    public function addContact(int $agencyId, array $contactData): AgencyContact
    {
        return AgencyContact::create([
            'agency_id' => $agencyId,
            'full_name' => $contactData['full_name'],
            'position' => $contactData['position'],
            'email' => $contactData['email'],
            'phone' => $contactData['phone'],
            'mobile' => $contactData['mobile'] ?? null,
            'is_primary' => $contactData['is_primary'] ?? false,
        ]);
    }

    /**
     * Update agency branding
     */
    public function updateBranding(int $agencyId, array $data): bool
    {
        $agency = Agency::findOrFail($agencyId);
        
        if (!$agency->branding) {
            $agency->branding()->create($data);
            return true;
        }
        
        return $agency->branding->update($data);
    }

    /**
     * Update agency services
     */
    public function updateServices(int $agencyId, array $data): bool
    {
        $agency = Agency::findOrFail($agencyId);
        
        if (!$agency->services) {
            $agency->services()->create($data);
            return true;
        }
        
        return $agency->services->update($data);
    }

    /**
     * Update agency compliance
     */
    public function updateCompliance(int $agencyId, array $data): bool
    {
        $agency = Agency::findOrFail($agencyId);
        
        if (!$agency->compliance) {
            $agency->compliance()->create($data);
            return true;
        }
        
        return $agency->compliance->update($data);
    }

    /**
     * Upload agency document
     */
    public function uploadDocument(int $agencyId, array $fileData): \App\Models\AgencyDocument
    {
        return \App\Models\AgencyDocument::create([
            'agency_id' => $agencyId,
            'document_type' => $fileData['document_type'],
            'document_name' => $fileData['document_name'],
            'file_path' => $fileData['file_path'],
            'file_type' => $fileData['file_type'] ?? null,
            'file_size' => $fileData['file_size'] ?? null,
            'expiry_date' => $fileData['expiry_date'] ?? null,
            'status' => 'pending',
        ]);
    }

    /**
     * Get all agencies with pagination
     */
    public function getAllPaginated(int $perPage = 15, array $filters = [])
    {
        $query = Agency::with(['primaryContact', 'users']);

        // Status filter
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // State filter
        if (isset($filters['state'])) {
            $query->where('state', $filters['state']);
        }

        // Search filter
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('agency_name', 'like', "%{$search}%")
                  ->orWhere('business_email', 'like', "%{$search}%")
                  ->orWhere('abn', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if (isset($filters['from_date'])) {
            $query->whereDate('created_at', '>=', $filters['from_date']);
        }
        
        if (isset($filters['to_date'])) {
            $query->whereDate('created_at', '<=', $filters['to_date']);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get agencies by status
     */
    public function getByStatus(string $status, int $perPage = 15)
    {
        return Agency::where('status', $status)
            ->with(['primaryContact'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get agencies by state
     */
    public function getByState(string $state, int $perPage = 15)
    {
        return Agency::where('state', $state)
            ->with(['primaryContact'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Delete agency (soft delete)
     */
    public function delete(int $id): bool
    {
        $agency = Agency::findOrFail($id);
        return $agency->delete();
    }

    /**
     * Restore soft deleted agency
     */
    public function restore(int $id): bool
    {
        $agency = Agency::withTrashed()->findOrFail($id);
        return $agency->restore();
    }

    /**
     * Check if ABN exists
     */
    public function abnExists(string $abn, ?int $excludeId = null): bool
    {
        $query = Agency::where('abn', $this->cleanABN($abn));
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Check if license number exists
     */
    public function licenseExists(string $licenseNumber, ?int $excludeId = null): bool
    {
        $query = Agency::where('license_number', $licenseNumber);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Check if business email exists
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $query = Agency::where('business_email', $email);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Get agency statistics
     */
    public function getStatistics(): array
    {
        return [
            'total' => Agency::count(),
            'active' => Agency::where('status', 'active')->count(),
            'pending' => Agency::where('status', 'pending')->count(),
            'suspended' => Agency::where('status', 'suspended')->count(),
            'inactive' => Agency::where('status', 'inactive')->count(),
            'verified' => Agency::whereNotNull('verified_at')->count(),
            'this_month' => Agency::whereMonth('created_at', now()->month)->count(),
            'this_week' => Agency::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];
    }

    /**
     * Get statistics by state
     */
    public function getStatisticsByState(): array
    {
        return Agency::selectRaw('state, COUNT(*) as count')
            ->groupBy('state')
            ->pluck('count', 'state')
            ->toArray();
    }

    /**
     * Clean ABN format (remove spaces)
     */
    private function cleanABN(string $abn): string
    {
        return preg_replace('/\s+/', '', $abn);
    }

    /**
     * Clean ACN format (remove spaces)
     */
    private function cleanACN(string $acn): string
    {
        return preg_replace('/\s+/', '', $acn);
    }
}