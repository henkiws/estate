<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserIncome;
use App\Models\UserEmployment;
use App\Models\UserPet;
use App\Models\UserVehicle;
use App\Models\UserAddress;
use App\Models\UserReference;
use App\Models\UserIdentification;
use App\Models\Agency;
use App\Models\AgencyContact;
use App\Models\AgencySetting;
use App\Models\AgencyBranding;
use App\Models\AgencyService;
use App\Models\AgencyCompliance;
use App\Models\AgencyDocumentRequirement;
use App\Models\Agent;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================================
        // ENSURE ALL ROLES EXIST
        // ============================================
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $agencyRole = Role::firstOrCreate(['name' => 'agency']);
        $agentRole = Role::firstOrCreate(['name' => 'agent']);
        $userRole = Role::firstOrCreate(['name' => 'user']); // USER ROLE
        
        // Create user role permissions if not exist
        $userPermissions = [
            'view published properties',
            'save properties',
            'submit applications',
            'submit enquiries',
            'view own applications',
            'view own enquiries',
            'view own saved properties',
        ];

        foreach ($userPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to user role
        $userRole->syncPermissions([
            'view published properties',
            'save properties',
            'submit applications',
            'submit enquiries',
            'view own applications',
            'view own enquiries',
            'view own saved properties',
        ]);
        
        $this->command->info('✅ All roles created (admin, agency, agent, user)');

        // ============================================
        // 1. CREATE ADMIN USER
        // ============================================
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@sorted.com',
            'password' => Hash::make('password'),
            'phone' => '0412345678',
            'position' => 'System Administrator',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');
        
        $this->command->info('✅ Admin created: admin@sorted.com / password');

        // ============================================
        // 2. CREATE SAMPLE PUBLIC USERS WITH PROFILES
        // ============================================
        $this->createPublicUsers();

        // ============================================
        // 3. CREATE AGENCIES WITH DIFFERENT STATUSES
        // ============================================
        $agencies = [
            // STATUS: Active + Subscribed (Fully operational)
            [
                'agency_name' => 'Sydney Premier Realty',
                'trading_name' => 'Sydney Premier',
                'abn' => '12345678901',
                'acn' => '123456789',
                'business_type' => 'company',
                'license_number' => 'NSW-20123456',
                'license_holder_name' => 'John Smith',
                'business_address' => '123 George Street, Sydney',
                'state' => 'NSW',
                'postcode' => '2000',
                'business_phone' => '(02) 9876 5432',
                'business_email' => 'info@sydneypremier.com.au',
                'website_url' => 'https://www.sydneypremier.com.au',
                'status' => 'active',
                'onboarding_completed_at' => now()->subDays(25),
                'verified_at' => now()->subDays(30),
                'verified_by' => null,
                'user' => [
                    'name' => 'John Smith',
                    'email' => 'john@sydneypremier.com.au',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()->subDays(30),
                ],
                'onboarding_completed' => true,
                'documents_uploaded' => true,
            ],
            
            // STATUS: Active (Documents approved, no subscription yet)
            [
                'agency_name' => 'Melbourne Property Group',
                'trading_name' => 'MPG Realty',
                'abn' => '23456789012',
                'acn' => '234567890',
                'business_type' => 'company',
                'license_number' => 'VIC-30234567',
                'license_holder_name' => 'Sarah Johnson',
                'business_address' => '456 Collins Street, Melbourne',
                'state' => 'VIC',
                'postcode' => '3000',
                'business_phone' => '(03) 9876 5432',
                'business_email' => 'info@mpgrealty.com.au',
                'website_url' => 'https://www.mpgrealty.com.au',
                'status' => 'approved',
                'verified_at' => now()->subDays(7),
                'verified_by' => null,
                'user' => [
                    'name' => 'Sarah Johnson',
                    'email' => 'sarah@mpgrealty.com.au',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()->subDays(7),
                ],
                'onboarding_completed' => true,
                'documents_uploaded' => true,
            ],
            
            // STATUS: Pending Review (Documents uploaded, awaiting admin approval)
            [
                'agency_name' => 'Brisbane Elite Properties',
                'trading_name' => 'Elite Properties QLD',
                'abn' => '34567890123',
                'acn' => '345678901',
                'business_type' => 'company',
                'license_number' => 'QLD-40345678',
                'license_holder_name' => 'Michael Chen',
                'business_address' => '789 Queen Street, Brisbane',
                'state' => 'QLD',
                'postcode' => '4000',
                'business_phone' => '(07) 3456 7890',
                'business_email' => 'info@eliteproperties.com.au',
                'website_url' => 'https://www.eliteproperties.com.au',
                'status' => 'pending',
                'verified_at' => null,
                'user' => [
                    'name' => 'Michael Chen',
                    'email' => 'michael@eliteproperties.com.au',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()->subDays(3),
                ],
                'onboarding_completed' => true,
                'documents_uploaded' => true,
            ],
            
            // STATUS: Email Verified (Step 1 completed, on Step 2 - uploading documents)
            [
                'agency_name' => 'Perth Coastal Realty',
                'trading_name' => 'Coastal Realty WA',
                'abn' => '45678901234',
                'acn' => null,
                'business_type' => 'sole_trader',
                'license_number' => 'WA-50456789',
                'license_holder_name' => 'Emma Wilson',
                'business_address' => '321 St Georges Terrace, Perth',
                'state' => 'WA',
                'postcode' => '6000',
                'business_phone' => '(08) 9876 5432',
                'business_email' => 'info@coastalrealty.com.au',
                'website_url' => 'https://www.coastalrealty.com.au',
                'status' => 'pending',
                'verified_at' => null,
                'user' => [
                    'name' => 'Emma Wilson',
                    'email' => 'emma@coastalrealty.com.au',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()->subDays(1),
                ],
                'onboarding_completed' => true,
                'documents_uploaded' => false,
            ],
            
            // STATUS: Email Verified (Step 1 completed, partial documents uploaded)
            [
                'agency_name' => 'Adelaide Property Partners',
                'trading_name' => 'APP Realty',
                'abn' => '56789012345',
                'acn' => '456789012',
                'business_type' => 'partnership',
                'license_number' => 'SA-60567890',
                'license_holder_name' => 'David Brown',
                'business_address' => '555 King William Street, Adelaide',
                'state' => 'SA',
                'postcode' => '5000',
                'business_phone' => '(08) 8234 5678',
                'business_email' => 'info@apprealty.com.au',
                'website_url' => 'https://www.apprealty.com.au',
                'status' => 'pending',
                'verified_at' => null,
                'user' => [
                    'name' => 'David Brown',
                    'email' => 'david@apprealty.com.au',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()->subHours(12),
                ],
                'onboarding_completed' => true,
                'documents_uploaded' => 'partial',
            ],
            
            // STATUS: Just Registered (Email NOT verified yet)
            [
                'agency_name' => 'Gold Coast Prestige Properties',
                'trading_name' => 'Prestige Properties GC',
                'abn' => '67890123456',
                'acn' => '567890123',
                'business_type' => 'company',
                'license_number' => 'QLD-70678901',
                'license_holder_name' => 'Jessica Lee',
                'business_address' => '888 Gold Coast Highway, Surfers Paradise',
                'state' => 'QLD',
                'postcode' => '4217',
                'business_phone' => '(07) 5555 1234',
                'business_email' => 'info@prestigegc.com.au',
                'website_url' => 'https://www.prestigegc.com.au',
                'status' => 'pending',
                'verified_at' => null,
                'user' => [
                    'name' => 'Jessica Lee',
                    'email' => 'jessica@prestigegc.com.au',
                    'password' => Hash::make('password'),
                    'email_verified_at' => null,
                ],
                'onboarding_completed' => false,
                'documents_uploaded' => false,
            ],
            
            // STATUS: Suspended (Was active, now suspended)
            [
                'agency_name' => 'Hobart Heritage Realty',
                'trading_name' => 'Heritage Realty TAS',
                'abn' => '78901234567',
                'acn' => '678901234',
                'business_type' => 'company',
                'license_number' => 'TAS-80789012',
                'license_holder_name' => 'Robert Taylor',
                'business_address' => '99 Elizabeth Street, Hobart',
                'state' => 'TAS',
                'postcode' => '7000',
                'business_phone' => '(03) 6234 5678',
                'business_email' => 'info@heritagetas.com.au',
                'website_url' => 'https://www.heritagetas.com.au',
                'status' => 'suspended',
                'verified_at' => now()->subMonths(3),
                'verified_by' => null,
                'user' => [
                    'name' => 'Robert Taylor',
                    'email' => 'robert@heritagetas.com.au',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()->subMonths(3),
                ],
                'onboarding_completed' => true,
                'documents_uploaded' => true,
            ],
        ];

        foreach ($agencies as $agencyData) {
            // Create Agency
            $userData = $agencyData['user'];
            $onboardingCompleted = $agencyData['onboarding_completed'];
            $documentsUploaded = $agencyData['documents_uploaded'];
            
            unset($agencyData['user']);
            unset($agencyData['onboarding_completed']);
            unset($agencyData['documents_uploaded']);
            
            if (isset($agencyData['verified_by']) && is_null($agencyData['verified_by'])) {
                $agencyData['verified_by'] = $admin->id;
            }
            
            $agency = Agency::create($agencyData);
            
            // Create User for Agency
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'phone' => $agency->business_phone,
                'position' => 'Principal/Licensee',
                'agency_id' => $agency->id,
                'email_verified_at' => $userData['email_verified_at'],
            ]);
            $user->assignRole('agency');
            
            // Create Primary Contact
            AgencyContact::create([
                'agency_id' => $agency->id,
                'user_id' => $user->id,
                'full_name' => $agency->license_holder_name,
                'position' => 'Principal/Licensee',
                'email' => $user->email,
                'phone' => $agency->business_phone,
                'mobile' => $agency->business_phone,
                'is_primary' => true,
            ]);
            
            // Create Settings
            AgencySetting::create([
                'agency_id' => $agency->id,
                'terms_accepted' => true,
                'terms_accepted_at' => now(),
                'terms_accepted_ip' => '127.0.0.1',
                'privacy_accepted' => true,
                'privacy_accepted_at' => now(),
                'privacy_accepted_ip' => '127.0.0.1',
            ]);
            
            // Create Branding
            AgencyBranding::create([
                'agency_id' => $agency->id,
                'brand_color' => '#0066FF',
                'description' => 'Leading real estate agency providing exceptional service.',
                'facebook_url' => 'https://facebook.com/' . str_replace(' ', '', $agency->agency_name),
                'instagram_url' => 'https://instagram.com/' . str_replace(' ', '', $agency->agency_name),
            ]);
            
            // Create Services
            AgencyService::create([
                'agency_id' => $agency->id,
                'service_areas' => json_encode(['CBD', 'Inner City', 'Eastern Suburbs']),
                'residential' => true,
                'commercial' => true,
                'rentals' => true,
                'sales' => true,
                'rural' => false,
                'industrial' => false,
                'number_of_agents' => rand(3, 10),
                'number_of_employees' => rand(5, 15),
            ]);
            
            // Create Compliance
            AgencyCompliance::create([
                'agency_id' => $agency->id,
                'trust_account_bsb' => '062000',
                'trust_account_number' => rand(10000000, 99999999),
                'trust_account_name' => $agency->agency_name . ' Trust Account',
                'trust_account_bank' => 'Commonwealth Bank',
                'professional_indemnity_provider' => 'AON Insurance',
                'professional_indemnity_policy_number' => 'PI' . rand(100000, 999999),
                'professional_indemnity_expiry' => now()->addYear(),
                'public_liability_provider' => 'AON Insurance',
                'public_liability_policy_number' => 'PL' . rand(100000, 999999),
                'public_liability_expiry' => now()->addYear(),
            ]);
            
            // Create Document Requirements
            if ($onboardingCompleted) {
                $this->createDocumentRequirements($agency, $documentsUploaded);
            }
            
            $statusEmoji = $this->getStatusEmoji($agency, $userData['email_verified_at'], $documentsUploaded);
            $this->command->info("{$statusEmoji} Agency: {$agency->agency_name} ({$user->email} / password)");
            
            // Create Agents and Properties for Active Agencies
            if ($agency->status === 'active') {
                $this->createAgentsForAgency($agency);
                $this->createPropertiesForAgency($agency);
            }
        }
        
        $this->command->info('');
        $this->command->info('🎉 Sample data seeded successfully!');
        $this->command->info('');
        $this->printLoginCredentials();
    }
    
    /**
     * Create sample public users with different profile statuses
     */
    private function createPublicUsers()
    {
        // USER 1: Complete Profile - Approved (Can apply for properties)
        $user1 = User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'phone' => '0412345001',
            'email_verified_at' => now()->subDays(10),
            'profile_completed' => true,
        ]);
        $user1->assignRole('user');
        
        $this->createCompleteProfile($user1, 'approved');
        $this->command->info("✅ Public User (Approved): {$user1->name} ({$user1->email} / password)");
        
        // USER 2: Complete Profile - Pending Review
        $user2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@email.com',
            'password' => Hash::make('password'),
            'phone' => '0412345002',
            'email_verified_at' => now()->subDays(2),
            'profile_completed' => false,
        ]);
        $user2->assignRole('user');
        
        $this->createCompleteProfile($user2, 'pending');
        $this->command->info("⏳ Public User (Pending): {$user2->name} ({$user2->email} / password)");
        
        // USER 3: Complete Profile - Rejected (Needs update)
        $user3 = User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob.johnson@email.com',
            'password' => Hash::make('password'),
            'phone' => '0412345003',
            'email_verified_at' => now()->subDays(5),
            'profile_completed' => false,
        ]);
        $user3->assignRole('user');
        
        $this->createCompleteProfile($user3, 'rejected');
        $this->command->info("❌ Public User (Rejected): {$user3->name} ({$user3->email} / password)");
        
        // USER 4: Incomplete Profile - Step 5 (Stopped at pets)
        $user4 = User::create([
            'name' => 'Alice Brown',
            'email' => 'alice.brown@email.com',
            'password' => Hash::make('password'),
            'phone' => '0412345004',
            'email_verified_at' => now()->subDays(1),
            'profile_current_step' => 5,
            'profile_completed' => false,
        ]);
        $user4->assignRole('user');
        
        $this->createPartialProfile($user4, 4); // Completed up to step 4
        $this->command->info("📝 Public User (Incomplete - Step 5): {$user4->name} ({$user4->email} / password)");
        
        // USER 5: No Profile (Just registered)
        $user5 = User::create([
            'name' => 'Charlie Davis',
            'email' => 'charlie.davis@email.com',
            'password' => Hash::make('password'),
            'phone' => '0412345005',
            'email_verified_at' => now(),
            'profile_current_step' => 1,
            'profile_completed' => false,
        ]);
        $user5->assignRole('user');
        
        $this->command->info("🆕 Public User (No Profile): {$user5->name} ({$user5->email} / password)");
        
        $this->command->info('');
    }
    
    /**
     * Create complete user profile with all 10 steps
     */
    private function createCompleteProfile($user, $status = 'pending')
    {
        // STEP 1: Personal Details + Introduction
        $profile = UserProfile::create([
            'user_id' => $user->id,
            'title' => ['Mr', 'Mrs', 'Ms', 'Dr'][rand(0, 3)],
            'first_name' => explode(' ', $user->name)[0],
            'middle_name' => null,
            'last_name' => explode(' ', $user->name)[1] ?? 'User',
            'surname' => null,
            'date_of_birth' => now()->subYears(rand(25, 45))->format('Y-m-d'),
            'email' => $user->email,
            'mobile_country_code' => '+61',
            'mobile_number' => $user->phone,
            'emergency_contact_name' => 'Emergency Contact',
            'emergency_contact_relationship' => 'Sibling',
            'emergency_contact_country_code' => '+61',
            'emergency_contact_number' => '0412999888',
            'emergency_contact_email' => 'emergency@email.com',
            'has_guarantor' => false,
            'introduction' => 'I am a responsible tenant looking for a quality property. I have stable employment and excellent rental history.',
            'status' => $status,
            'submitted_at' => $status !== 'draft' ? now()->subDays(rand(1, 7)) : null,
            'approved_at' => $status === 'approved' ? now()->subDays(rand(0, 3)) : null,
            'rejected_at' => $status === 'rejected' ? now()->subDays(rand(0, 2)) : null,
            'rejection_reason' => $status === 'rejected' ? 'Please upload clearer ID documents with minimum 80 points.' : null,
            'terms_accepted' => true,
            'signature' => $user->name,
            'terms_accepted_at' => now()->subDays(rand(1, 7)),
        ]);
        
        // STEP 3: Income Sources
        UserIncome::create([
            'user_id' => $user->id,
            'source_of_income' => 'Full-time Employment',
            'net_weekly_amount' => rand(800, 2000),
            'bank_statement_path' => 'private/bank-statements/' . $user->id . '/statement.pdf',
        ]);
        
        // STEP 4: Employment History
        UserEmployment::create([
            'user_id' => $user->id,
            'company_name' => 'Tech Company Pty Ltd',
            'address' => '123 Business Street, Sydney NSW 2000',
            'position' => 'Software Developer',
            'gross_annual_salary' => rand(70000, 120000),
            'manager_full_name' => 'Manager Name',
            'contact_number' => '0298765432',
            'email' => 'manager@techcompany.com',
            'employment_letter_path' => 'private/employment-letters/' . $user->id . '/letter.pdf',
            'start_date' => now()->subYears(rand(1, 5))->format('Y-m-d'),
            'still_employed' => true,
            'end_date' => null,
        ]);
        
        // STEP 5: Pets (some users have pets)
        if (rand(0, 1)) {
            UserPet::create([
                'user_id' => $user->id,
                'type' => 'dog',
                'breed' => 'Labrador',
                'desexed' => 'yes',
                'size' => 'medium',
                'registration_number' => 'PET' . rand(100000, 999999),
                'document_path' => 'private/pet-documents/' . $user->id . '/registration.pdf',
            ]);
        }
        
        // STEP 6: Vehicles
        UserVehicle::create([
            'user_id' => $user->id,
            'vehicle_type' => 'car',
            'year' => rand(2015, 2023),
            'make' => 'Toyota',
            'model' => 'Camry',
            'state' => 'NSW',
            'registration_number' => 'ABC' . rand(100, 999),
        ]);
        
        // STEP 7: Address History
        UserAddress::create([
            'user_id' => $user->id,
            'living_arrangement' => 'renting_agent',
            'address' => rand(1, 999) . ' Main Street, Sydney NSW 2000',
            'years_lived' => rand(1, 5),
            'months_lived' => rand(0, 11),
            'reason_for_leaving' => 'Looking for bigger property',
            'different_postal_address' => false,
            'postal_code' => null,
            'is_current' => true,
        ]);
        
        // STEP 8: References
        UserReference::create([
            'user_id' => $user->id,
            'full_name' => 'Reference Name',
            'relationship' => 'Previous Landlord',
            'mobile_country_code' => '+61',
            'mobile_number' => '0412888777',
            'email' => 'reference@email.com',
        ]);
        
        UserReference::create([
            'user_id' => $user->id,
            'full_name' => 'Another Reference',
            'relationship' => 'Employer',
            'mobile_country_code' => '+61',
            'mobile_number' => '0412777666',
            'email' => 'employer@email.com',
        ]);
        
        // STEP 9: Identification Documents
        $idTypes = [
            ['type' => 'australian_drivers_licence', 'points' => 40],
            ['type' => 'passport', 'points' => 70],
            ['type' => 'birth_certificate', 'points' => 70],
            ['type' => 'medicare', 'points' => 25],
        ];
        
        // Add 2 ID documents to ensure 80+ points
        $selectedIds = array_rand($idTypes, 2);
        foreach ($selectedIds as $index) {
            $idType = $idTypes[$index];
            UserIdentification::create([
                'user_id' => $user->id,
                'identification_type' => $idType['type'],
                'points' => $idType['points'],
                'document_path' => 'private/identification-documents/' . $user->id . '/' . $idType['type'] . '.pdf',
                'expiry_date' => now()->addYears(rand(1, 5))->format('Y-m-d'),
            ]);
        }
    }
    
    /**
     * Create partial user profile (incomplete)
     */
    private function createPartialProfile($user, $completedUpToStep)
    {
        if ($completedUpToStep >= 1) {
            // STEP 1: Personal Details
            UserProfile::create([
                'user_id' => $user->id,
                'title' => 'Mr',
                'first_name' => explode(' ', $user->name)[0],
                'middle_name' => null,
                'last_name' => explode(' ', $user->name)[1] ?? 'User',
                'date_of_birth' => now()->subYears(30)->format('Y-m-d'),
                'email' => $user->email,
                'mobile_country_code' => '+61',
                'mobile_number' => $user->phone,
                'emergency_contact_name' => 'Emergency Contact',
                'emergency_contact_relationship' => 'Sibling',
                'emergency_contact_country_code' => '+61',
                'emergency_contact_number' => '0412999888',
                'emergency_contact_email' => 'emergency@email.com',
                'has_guarantor' => false,
                'status' => 'draft',
            ]);
        }
        
        if ($completedUpToStep >= 3) {
            // STEP 3: Income
            UserIncome::create([
                'user_id' => $user->id,
                'source_of_income' => 'Full-time Employment',
                'net_weekly_amount' => 1200,
            ]);
        }
        
        if ($completedUpToStep >= 4) {
            // STEP 4: Employment
            UserEmployment::create([
                'user_id' => $user->id,
                'company_name' => 'Company Name',
                'address' => '123 Street, City',
                'position' => 'Position',
                'gross_annual_salary' => 80000,
                'manager_full_name' => 'Manager',
                'contact_number' => '0298765432',
                'email' => 'manager@company.com',
                'start_date' => now()->subYears(2)->format('Y-m-d'),
                'still_employed' => true,
            ]);
        }
    }
    
    /**
     * Create document requirements for agency
     */
    private function createDocumentRequirements(Agency $agency, $documentsUploaded)
    {
        $documents = [
            [
                'name' => 'Real Estate License Certificate',
                'description' => 'A copy of your valid real estate license or certificate',
                'is_required' => true,
            ],
            [
                'name' => 'Proof of Identity',
                'description' => 'Government-issued ID (Passport, Driver\'s License, etc.)',
                'is_required' => true,
            ],
            [
                'name' => 'ABN Registration Certificate',
                'description' => 'Official ABN registration document from the ATO',
                'is_required' => true,
            ],
            [
                'name' => 'Professional Indemnity Insurance',
                'description' => 'Current professional indemnity insurance certificate',
                'is_required' => true,
            ],
            [
                'name' => 'Public Liability Insurance',
                'description' => 'Current public liability insurance certificate',
                'is_required' => true,
            ],
        ];
        
        foreach ($documents as $index => $doc) {
            $docRequirement = AgencyDocumentRequirement::create([
                'agency_id' => $agency->id,
                'name' => $doc['name'],
                'description' => $doc['description'],
                'is_required' => $doc['is_required'],
                'status' => 'pending',
            ]);
            
            // Upload documents based on status
            if ($documentsUploaded === true) {
                $docRequirement->update([
                    'file_path' => 'private/agency-documents/' . $agency->id . '/' . $doc['name'] . '.pdf',
                    'file_name' => $doc['name'] . '.pdf',
                    'file_type' => 'application/pdf',
                    'file_size' => rand(100000, 500000),
                    'status' => 'approved',
                    'uploaded_at' => now()->subDays(rand(1, 5)),
                    'reviewed_at' => now()->subDays(rand(0, 2)),
                ]);
            } elseif ($documentsUploaded === 'partial') {
                if ($index < 3) {
                    $docRequirement->update([
                        'file_path' => 'private/agency-documents/' . $agency->id . '/' . $doc['name'] . '.pdf',
                        'file_name' => $doc['name'] . '.pdf',
                        'file_type' => 'application/pdf',
                        'file_size' => rand(100000, 500000),
                        'status' => 'pending_review',
                        'uploaded_at' => now()->subHours(rand(1, 10)),
                    ]);
                }
            }
        }
    }
    
    /**
     * Create agents for an agency
     */
    private function createAgentsForAgency(Agency $agency)
    {
        $agentCount = rand(2, 4);
        
        $agentNames = [
            ['first' => 'James', 'last' => 'Taylor', 'position' => 'Senior Sales Agent', 'specializations' => ['Residential Sales', 'Luxury Properties', 'First Home Buyers'], 'languages' => ['English', 'Mandarin'], 'bio' => 'Award-winning agent with over 10 years of experience in luxury residential sales.', 'employment_type' => 'full_time', 'commission_rate' => 2.5],
            ['first' => 'Emily', 'last' => 'Davis', 'position' => 'Property Manager', 'specializations' => ['Property Management', 'Rentals', 'Residential'], 'languages' => ['English', 'Spanish'], 'bio' => 'Dedicated property manager specializing in residential portfolio management.', 'employment_type' => 'full_time', 'commission_rate' => 8.0],
            ['first' => 'Oliver', 'last' => 'Martin', 'position' => 'Sales Agent', 'specializations' => ['Residential Sales', 'Investments', 'Auctions'], 'languages' => ['English'], 'bio' => 'Dynamic sales professional with a passion for helping clients find their dream home.', 'employment_type' => 'full_time', 'commission_rate' => 2.0],
            ['first' => 'Sophie', 'last' => 'Anderson', 'position' => 'Commercial Sales Agent', 'specializations' => ['Commercial Sales', 'Investments', 'Business Sales'], 'languages' => ['English', 'Italian'], 'bio' => 'Experienced commercial real estate specialist with strong negotiation skills.', 'employment_type' => 'full_time', 'commission_rate' => 3.0],
            ['first' => 'Liam', 'last' => 'Thomas', 'position' => 'Junior Sales Agent', 'specializations' => ['Residential Sales', 'First Home Buyers'], 'languages' => ['English', 'Vietnamese'], 'bio' => 'Enthusiastic new agent committed to providing exceptional service.', 'employment_type' => 'part_time', 'commission_rate' => 1.5],
        ];
        
        shuffle($agentNames);
        
        for ($i = 0; $i < $agentCount; $i++) {
            $profile = $agentNames[$i];
            $agentName = $agentNames[$i];
            $fullName = $agentName['first'] . ' ' . $agentName['last'];
            
            $emailPrefix = strtolower($agentName['first'] . '.' . $agentName['last']);
            $emailDomain = str_replace(['https://www.', 'https://', 'http://www.', 'http://'], '', $agency->website_url);
            
            $email = $emailPrefix . $i . '@' . $emailDomain;
            
            $counter = 0;
            while (User::where('email', $email)->exists()) {
                $counter++;
                $email = $emailPrefix . $i . $counter . '@' . $emailDomain;
            }
            
            $agentUser = User::create([
                'name' => $fullName,
                'email' => $email,
                'password' => Hash::make('password'),
                'phone' => '04' . rand(10000000, 99999999),
                'position' => 'Sales Agent',
                'agency_id' => $agency->id,
                'email_verified_at' => now(),
            ]);
            $agentUser->assignRole('agent');

            Agent::create([
                'agency_id' => $agency->id,
                'user_id' => $agentUser->id,
                'first_name' => $profile['first'],
                'last_name' => $profile['last'],
                'email' => $email,
                'phone' => $agency->business_phone,
                'mobile' => '+61 4' . rand(10, 99) . ' ' . rand(100, 999) . ' ' . rand(100, 999),
                'license_number' => $agency->state . '-' . rand(10000000, 99999999),
                'license_expiry' => now()->addYears(rand(1, 3)),
                'position' => $profile['position'],
                'employment_type' => $profile['employment_type'],
                'commission_rate' => $profile['commission_rate'],
                'bio' => $profile['bio'],
                'specializations' => $profile['specializations'],
                'languages' => $profile['languages'],
                'address_line1' => $agency->business_address,
                'state' => $agency->state,
                'postcode' => $agency->postcode,
                'country' => 'Australia',
                'status' => $i === 0 ? 'active' : (rand(0, 10) > 2 ? 'active' : 'on_leave'),
                'started_at' => now()->subMonths(rand(1, 36)),
                'is_featured' => $i === 0,
                'is_accepting_new_listings' => true,
            ]);
            
            $this->command->info("  └─ Agent: {$fullName} ({$email} / password)");
        }
    }
    
    /**
     * Get status emoji for display
     */
    private function getStatusEmoji(Agency $agency, $emailVerified, $documentsUploaded)
    {
        if ($agency->status === 'active') {
            return '✅';
        } elseif ($agency->status === 'suspended') {
            return '⛔';
        } elseif ($agency->status === 'pending' && $documentsUploaded === true) {
            return '⏳';
        } elseif ($agency->status === 'pending' && $documentsUploaded === 'partial') {
            return '📄';
        } elseif ($agency->status === 'pending' && $emailVerified) {
            return '📧';
        } else {
            return '🆕';
        }
    }
    
    /**
     * Print login credentials
     */
    private function printLoginCredentials()
    {
        $this->command->info('📧 LOGIN CREDENTIALS');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('');
        $this->command->info('👤 ADMIN:');
        $this->command->info('   Email: admin@sorted.com');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('👥 PUBLIC USERS (Role: user):');
        $this->command->info('   ✅ user@test.com / password - Profile APPROVED (Can apply)');
        $this->command->info('   ⏳ jane.smith@email.com / password - Profile PENDING (Waiting review)');
        $this->command->info('   ❌ bob.johnson@email.com / password - Profile REJECTED (Needs update)');
        $this->command->info('   📝 alice.brown@email.com / password - Profile INCOMPLETE (Step 5)');
        $this->command->info('   🆕 charlie.davis@email.com / password - NO PROFILE (Just registered)');
        $this->command->info('');
        $this->command->info('🏢 AGENCIES (All passwords: password)');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('✅ ACTIVE + SUBSCRIBED:');
        $this->command->info('   john@sydneypremier.com.au');
        $this->command->info('   └─ Status: Active, Has agents, Fully operational');
        $this->command->info('');
        $this->command->info('✅ APPROVED (Need to choose subscription):');
        $this->command->info('   sarah@mpgrealty.com.au');
        $this->command->info('   └─ Status: Approved, See subscription page, Has agents');
        $this->command->info('');
        $this->command->info('⏳ PENDING REVIEW (Awaiting admin approval):');
        $this->command->info('   michael@eliteproperties.com.au');
        $this->command->info('   └─ Status: All docs uploaded, waiting for admin approval');
        $this->command->info('');
        $this->command->info('📧 EMAIL VERIFIED (On Step 2 - No documents):');
        $this->command->info('   emma@coastalrealty.com.au');
        $this->command->info('   └─ Status: Email verified, On Step 2, No documents uploaded');
        $this->command->info('');
        $this->command->info('📄 EMAIL VERIFIED (On Step 2 - Partial documents):');
        $this->command->info('   david@apprealty.com.au');
        $this->command->info('   └─ Status: Email verified, 3 of 5 documents uploaded');
        $this->command->info('');
        $this->command->info('🆕 JUST REGISTERED (Email NOT verified):');
        $this->command->info('   jessica@prestigegc.com.au');
        $this->command->info('   └─ Status: Just registered, needs to verify email');
        $this->command->info('');
        $this->command->info('⛔ SUSPENDED:');
        $this->command->info('   robert@heritagetas.com.au');
        $this->command->info('   └─ Status: Suspended account');
        $this->command->info('');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('');
        $this->command->info('🎯 TESTING FLOW:');
        $this->command->info('PUBLIC USERS:');
        $this->command->info('1. user@test.com - Test property applications (APPROVED profile)');
        $this->command->info('2. jane.smith@email.com - View pending profile status');
        $this->command->info('3. bob.johnson@email.com - Test updating rejected profile');
        $this->command->info('4. alice.brown@email.com - Continue incomplete profile (Step 5)');
        $this->command->info('5. charlie.davis@email.com - Start profile from Step 1');
        $this->command->info('');
        $this->command->info('AGENCIES:');
        $this->command->info('6. jessica@ - Test email verification');
        $this->command->info('7. emma@ - Test Step 2 onboarding (upload documents)');
        $this->command->info('8. david@ - Test Step 2 with partial upload');
        $this->command->info('9. michael@ - Test pending review status');
        $this->command->info('10. sarah@ - Test approved status (subscription page)');
        $this->command->info('11. john@ - Test full active agency with dashboard');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }

    private function createPropertiesForAgency(Agency $agency)
    {
        $propertyCount = rand(5, 12);
        
        $agents = Agent::where('agency_id', $agency->id)
            ->where('status', 'active')
            ->get();
        
        if ($agents->isEmpty()) {
            return;
        }
        
        $propertyTypes = ['house', 'apartment', 'unit', 'townhouse', 'villa'];
        $listingTypes = ['sale', 'rent'];
        $statuses = ['active', 'active', 'active', 'under_contract', 'sold', 'leased'];
        
        $suburbs = $this->getSuburbsForState($agency->state);
        $streetNames = ['Main', 'High', 'Park', 'Church', 'Station', 'Queen', 'King', 'George', 'Victoria', 'Elizabeth'];
        $streetTypes = ['Street', 'Road', 'Avenue', 'Drive', 'Lane', 'Terrace'];
        
        $features = [
            'Air Conditioning', 'Built-in Wardrobes', 'Dishwasher', 'Gas Cooking', 'Swimming Pool',
            'Alarm System', 'Balcony', 'Deck', 'Courtyard', 'Garden', 'Study', 'Ensuite',
            'Walk-in Wardrobe', 'Ducted Heating', 'Floorboards', 'Remote Garage', 'Intercom',
        ];
        
        for ($i = 0; $i < $propertyCount; $i++) {
            $listingType = $listingTypes[array_rand($listingTypes)];
            $propertyType = $propertyTypes[array_rand($propertyTypes)];
            $status = $statuses[array_rand($statuses)];
            
            if ($listingType === 'sale' && $status === 'leased') {
                $status = 'sold';
            } elseif ($listingType === 'rent' && $status === 'sold') {
                $status = 'leased';
            }
            
            $suburb = $suburbs[array_rand($suburbs)];
            $streetName = $streetNames[array_rand($streetNames)];
            $streetType = $streetTypes[array_rand($streetTypes)];
            $streetNumber = rand(1, 999);
            
            $bedrooms = rand(1, 5);
            $bathrooms = rand(1, 3);
            $parkingSpaces = rand(0, 3);
            
            if ($listingType === 'sale') {
                $price = rand(300000, 2000000);
                $price = round($price / 10000) * 10000;
                $rentPerWeek = null;
                $bondAmount = null;
            } else {
                $price = null;
                $rentPerWeek = rand(250, 1200);
                $rentPerWeek = round($rentPerWeek / 10) * 10;
                $bondAmount = $rentPerWeek * 4;
            }
            
            $selectedFeatures = array_rand(array_flip($features), rand(3, 8));
            $listingAgent = $agents->random();
            
            $unitNumber = ($propertyType === 'apartment' || $propertyType === 'unit') && rand(0, 1) 
                ? rand(1, 99) 
                : null;
            
            $property = Property::create([
                'agency_id' => $agency->id,
                'listing_agent_id' => $listingAgent->id,
                'property_manager_id' => $listingType === 'rent' ? $listingAgent->id : null,
                'property_type' => $propertyType,
                'listing_type' => $listingType,
                'status' => $status,
                'street_number' => $streetNumber,
                'street_name' => $streetName,
                'street_type' => $streetType,
                'unit_number' => $unitNumber,
                'suburb' => $suburb,
                'state' => $agency->state,
                'postcode' => $this->getPostcodeForSuburb($suburb, $agency->state),
                'country' => 'Australia',
                'bedrooms' => $bedrooms,
                'bathrooms' => $bathrooms,
                'parking_spaces' => $parkingSpaces,
                'garages' => rand(0, 2),
                'land_area' => rand(200, 1000),
                'land_area_unit' => 'sqm',
                'floor_area' => $propertyType === 'house' ? rand(150, 400) : rand(60, 150),
                'floor_area_unit' => 'sqm',
                'year_built' => rand(1950, 2023),
                'price' => $price,
                'price_display' => true,
                'rent_per_week' => $rentPerWeek,
                'bond_amount' => $bondAmount,
                'available_from' => $listingType === 'rent' ? now()->addDays(rand(0, 60)) : null,
                'headline' => $this->generatePropertyHeadline($propertyType, $bedrooms, $suburb),
                'description' => $this->generatePropertyDescription($propertyType, $bedrooms, $bathrooms, $suburb),
                'features' => $selectedFeatures,
                'is_featured' => $i < 2,
                'view_count' => rand(10, 500),
                'enquiry_count' => rand(0, 50),
                'inspection_count' => rand(0, 20),
                'listed_at' => in_array($status, ['active', 'under_contract']) ? now()->subDays(rand(1, 90)) : null,
                'sold_at' => $status === 'sold' ? now()->subDays(rand(1, 30)) : null,
                'leased_at' => $status === 'leased' ? now()->subDays(rand(1, 30)) : null,
                'sale_price' => $status === 'sold' ? $price : null,
                'is_published' => in_array($status, ['active', 'under_contract']),
                'published_at' => in_array($status, ['active', 'under_contract']) ? now()->subDays(rand(1, 90)) : null,
            ]);
            
            $this->command->info("  🏠 Property: {$property->short_address} ({$status})");
        }
    }

    private function getSuburbsForState($state)
    {
        $suburbs = [
            'NSW' => ['Sydney', 'Bondi', 'Manly', 'Parramatta', 'Newcastle', 'Wollongong', 'Surry Hills', 'Newtown', 'Chatswood', 'Liverpool'],
            'VIC' => ['Melbourne', 'St Kilda', 'Brighton', 'Richmond', 'Carlton', 'Geelong', 'Fitzroy', 'South Yarra', 'Doncaster', 'Glen Waverley'],
            'QLD' => ['Brisbane', 'Surfers Paradise', 'Cairns', 'Toowoomba', 'Southport', 'Gold Coast', 'Fortitude Valley', 'New Farm', 'Paddington', 'Indooroopilly'],
            'WA' => ['Perth', 'Fremantle', 'Subiaco', 'Scarborough', 'Cottesloe', 'Northbridge', 'Victoria Park', 'Mount Lawley', 'Leederville', 'Claremont'],
            'SA' => ['Adelaide', 'Glenelg', 'North Adelaide', 'Unley', 'Prospect', 'Norwood', 'Brighton', 'Henley Beach', 'Burnside', 'Walkerville'],
            'TAS' => ['Hobart', 'Launceston', 'Sandy Bay', 'North Hobart', 'Battery Point', 'South Hobart', 'West Hobart', 'Bellerive', 'New Town', 'Glenorchy'],
        ];
        
        return $suburbs[$state] ?? ['Capital City', 'Suburb', 'Downtown', 'Uptown'];
    }

    private function getPostcodeForSuburb($suburb, $state)
    {
        $postcodes = [
            'NSW' => ['2000' => 2999],
            'VIC' => ['3000' => 3999],
            'QLD' => ['4000' => 4999],
            'WA' => ['6000' => 6999],
            'SA' => ['5000' => 5999],
            'TAS' => ['7000' => 7999],
        ];
        
        $range = $postcodes[$state] ?? ['2000' => 2999];
        return rand(array_keys($range)[0], array_values($range)[0]);
    }

    private function generatePropertyHeadline($type, $bedrooms, $suburb)
    {
        $adjectives = ['Stunning', 'Beautiful', 'Modern', 'Spacious', 'Charming', 'Luxurious', 'Contemporary', 'Elegant', 'Impressive', 'Stylish'];
        $adjective = $adjectives[array_rand($adjectives)];
        
        $typeNames = [
            'house' => 'Family Home',
            'apartment' => 'Apartment',
            'unit' => 'Unit',
            'townhouse' => 'Townhouse',
            'villa' => 'Villa',
        ];
        
        $typeName = $typeNames[$type] ?? ucfirst($type);
        
        return "{$adjective} {$bedrooms} Bedroom {$typeName} in {$suburb}";
    }

    private function generatePropertyDescription($type, $bedrooms, $bathrooms, $suburb)
    {
        $descriptions = [
            "This beautiful {$bedrooms} bedroom, {$bathrooms} bathroom {$type} offers exceptional living in the heart of {$suburb}. Featuring modern finishes throughout, spacious living areas, and a well-appointed kitchen, this property is perfect for families or professionals seeking quality accommodation.",
            
            "Discover the perfect blend of comfort and style in this {$bedrooms} bedroom {$type}. Located in sought-after {$suburb}, this property boasts contemporary design, quality fixtures, and convenient access to local amenities. Don't miss this opportunity to secure your dream home.",
            
            "Welcome to this impressive {$bedrooms} bedroom residence in prime {$suburb} location. Offering generous living spaces, {$bathrooms} modern bathrooms, and quality finishes throughout, this property represents excellent value in today's market. Inspection highly recommended.",
        ];
        
        return $descriptions[array_rand($descriptions)];
    }
}