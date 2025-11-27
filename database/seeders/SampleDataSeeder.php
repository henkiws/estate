<?php

namespace Database\Seeders;

use App\Models\User;
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

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $agencyRole = Role::firstOrCreate(['name' => 'agency']);
        $agentRole = Role::firstOrCreate(['name' => 'agent']);

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
        // 2. CREATE AGENCIES WITH DIFFERENT STATUSES
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
                'verified_by' => null, // Will be set to admin->id
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
                'status' => 'active',
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
                    'email_verified_at' => now()->subDays(1), // Email verified recently
                ],
                'onboarding_completed' => true,
                'documents_uploaded' => false, // Still uploading documents
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
                'documents_uploaded' => 'partial', // Some documents uploaded
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
                    'email_verified_at' => null, // Email NOT verified
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
            
            // ============================================
            // CREATE DOCUMENT REQUIREMENTS
            // ============================================
            if ($onboardingCompleted) {
                $this->createDocumentRequirements($agency, $documentsUploaded);
            }
            
            $statusEmoji = $this->getStatusEmoji($agency, $userData['email_verified_at'], $documentsUploaded);
            $this->command->info("{$statusEmoji} Agency: {$agency->agency_name} ({$user->email} / password)");
            
            // ============================================
            // CREATE AGENTS UNDER ACTIVE AGENCIES
            // ============================================
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
                // All documents uploaded and approved
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
                // Only first 2-3 documents uploaded
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
            // If false, leave as pending with no upload
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
        $this->command->info('1. jessica@ - Test email verification');
        $this->command->info('2. emma@ - Test Step 2 onboarding (upload documents)');
        $this->command->info('3. david@ - Test Step 2 with partial upload');
        $this->command->info('4. michael@ - Test pending review status');
        $this->command->info('5. sarah@ - Test approved status (subscription page)');
        $this->command->info('6. john@ - Test full active agency with dashboard');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }

    private function createPropertiesForAgency(Agency $agency)
    {
        $propertyCount = rand(5, 12);
        
        // Get active agents
        $agents = Agent::where('agency_id', $agency->id)
            ->where('status', 'active')
            ->get();
        
        if ($agents->isEmpty()) {
            return; // No agents, skip properties
        }
        
        $propertyTypes = ['house', 'apartment', 'unit', 'townhouse', 'villa'];
        $listingTypes = ['sale', 'rent'];
        $statuses = ['active', 'active', 'active', 'under_contract', 'sold', 'leased']; // More active
        
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
            
            // Adjust status based on listing type
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
            
            // Price based on listing type
            if ($listingType === 'sale') {
                $price = rand(300000, 2000000);
                $price = round($price / 10000) * 10000; // Round to nearest 10k
                $rentPerWeek = null;
                $bondAmount = null;
            } else {
                $price = null;
                $rentPerWeek = rand(250, 1200);
                $rentPerWeek = round($rentPerWeek / 10) * 10; // Round to nearest 10
                $bondAmount = $rentPerWeek * 4;
            }
            
            // Select random features
            $selectedFeatures = array_rand(array_flip($features), rand(3, 8));
            
            // Randomly assign agent
            $listingAgent = $agents->random();
            
            // Create address parts
            $unitNumber = ($propertyType === 'apartment' || $propertyType === 'unit') && rand(0, 1) 
                ? rand(1, 99) 
                : null;
            
            $property = Property::create([
                'agency_id' => $agency->id,
                'listing_agent_id' => $listingAgent->id,
                'property_manager_id' => $listingType === 'rent' ? $listingAgent->id : null,
                // property_code auto-generated
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
                'is_featured' => $i < 2, // First 2 properties are featured
                'view_count' => rand(10, 500),
                'enquiry_count' => rand(0, 50),
                'inspection_count' => rand(0, 20),
                'listed_at' => in_array($status, ['active', 'under_contract']) ? now()->subDays(rand(1, 90)) : null,
                'sold_at' => $status === 'sold' ? now()->subDays(rand(1, 30)) : null,
                'leased_at' => $status === 'leased' ? now()->subDays(rand(1, 30)) : null,
                'sale_price' => $status === 'sold' ? $price : null,
                'is_published' => in_array($status, ['active', 'under_contract']),
                'published_at' => in_array($status, ['active', 'under_contract']) ? now()->subDays(rand(1, 90)) : null,
                // slug auto-generated
            ]);
            
            $this->command->info("  🏠 Property: {$property->short_address} ({$status})");
        }
    }

    /**
     * Get suburbs for a state
     */
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

    /**
     * Get postcode for suburb
     */
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

    /**
     * Generate property headline
     */
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

    /**
     * Generate property description
     */
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