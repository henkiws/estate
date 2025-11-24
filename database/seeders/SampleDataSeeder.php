<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Agency;
use App\Models\AgencyContact;
use App\Models\AgencySetting;
use App\Models\AgencyBranding;
use App\Models\AgencyService;
use App\Models\AgencyCompliance;
use App\Models\Agent;
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
        // 2. CREATE AGENCIES WITH USERS
        // ============================================
        $agencies = [
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
                'verified_at' => now(),
                'verified_by' => $admin->id,
                'user' => [
                    'name' => 'John Smith',
                    'email' => 'john@sydneypremier.com.au',
                    'password' => Hash::make('password'),
                ],
            ],
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
                'verified_at' => now(),
                'verified_by' => $admin->id,
                'user' => [
                    'name' => 'Sarah Johnson',
                    'email' => 'sarah@mpgrealty.com.au',
                    'password' => Hash::make('password'),
                ],
            ],
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
                ],
            ],
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
                ],
            ],
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
                'status' => 'suspended',
                'verified_at' => now(),
                'verified_by' => $admin->id,
                'user' => [
                    'name' => 'David Brown',
                    'email' => 'david@apprealty.com.au',
                    'password' => Hash::make('password'),
                ],
            ],
        ];

        foreach ($agencies as $agencyData) {
            // Create Agency
            $userData = $agencyData['user'];
            unset($agencyData['user']);
            
            $agency = Agency::create($agencyData);
            
            // Create User for Agency
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'phone' => $agency->business_phone,
                'position' => 'Principal/Licensee',
                'agency_id' => $agency->id,
                'email_verified_at' => now(),
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
            
            $this->command->info("✅ Agency created: {$agency->agency_name} ({$user->email} / password)");
            
            // ============================================
            // 3. CREATE AGENTS UNDER ACTIVE AGENCIES
            // ============================================
            if ($agency->status === 'active') {
                $agentCount = rand(2, 4);
                
                $agentNames = [
                    ['first' => 'James', 'last' => 'Taylor'],
                    ['first' => 'Emily', 'last' => 'Davis'],
                    ['first' => 'Oliver', 'last' => 'Martin'],
                    ['first' => 'Sophie', 'last' => 'Anderson'],
                    ['first' => 'Liam', 'last' => 'Thomas'],
                    ['first' => 'Ava', 'last' => 'White'],
                    ['first' => 'Noah', 'last' => 'Garcia'],
                    ['first' => 'Isabella', 'last' => 'Martinez'],
                    ['first' => 'Ethan', 'last' => 'Robinson'],
                    ['first' => 'Mia', 'last' => 'Clark'],
                ];
                
                // Shuffle to get random agents
                shuffle($agentNames);
                
                for ($i = 0; $i < $agentCount; $i++) {
                    $agentName = $agentNames[$i];
                    $fullName = $agentName['first'] . ' ' . $agentName['last'];
                    
                    // Create unique email with agency identifier and counter
                    $emailPrefix = strtolower($agentName['first'] . '.' . $agentName['last']);
                    $emailDomain = str_replace(['https://www.', 'https://', 'http://www.', 'http://'], '', $agency->website_url);
                    
                    // Add timestamp or random number to ensure uniqueness
                    $email = $emailPrefix . $i . '@' . $emailDomain;
                    
                    // Check if email exists, if yes, add more unique identifier
                    $counter = 0;
                    while (User::where('email', $email)->exists()) {
                        $counter++;
                        $email = $emailPrefix . $i . $counter . '@' . $emailDomain;
                    }
                    
                    // Create Agent User
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
                    
                    // Create Agent Profile
                    Agent::create([
                        'agency_id' => $agency->id,
                        'user_id' => $agentUser->id,
                        'agent_name' => $fullName,
                        'license_number' => $agency->state . '-' . rand(10000000, 99999999),
                        'email' => $email,
                        'mobile' => $agentUser->phone,
                        'position' => 'Sales Agent',
                        'bio' => 'Experienced real estate professional specializing in residential properties.',
                        'specializations' => json_encode(['Residential', 'Sales']),
                        'status' => 'active',
                    ]);
                    
                    $this->command->info("  └─ Agent created: {$fullName} ({$email} / password)");
                }
            }
        }
        
        $this->command->info('');
        $this->command->info('🎉 Sample data seeded successfully!');
        $this->command->info('');
        $this->command->info('📧 Login Credentials:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('Admin:');
        $this->command->info('  Email: admin@sorted.com');
        $this->command->info('  Password: password');
        $this->command->info('');
        $this->command->info('Agencies:');
        $this->command->info('  john@sydneypremier.com.au / password (Active)');
        $this->command->info('  sarah@mpgrealty.com.au / password (Active)');
        $this->command->info('  michael@eliteproperties.com.au / password (Pending)');
        $this->command->info('  emma@coastalrealty.com.au / password (Pending)');
        $this->command->info('  david@apprealty.com.au / password (Suspended)');
        $this->command->info('');
        $this->command->info('Agents: Check under each active agency');
        $this->command->info('  All agent passwords: password');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}