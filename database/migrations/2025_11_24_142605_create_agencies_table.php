<?php

// database/migrations/2024_01_01_000001_create_agencies_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Agencies table
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            
            // Basic Information (Section 1)
            $table->string('agency_name');
            $table->string('trading_name')->nullable();
            $table->string('abn', 14)->unique();
            $table->string('acn', 11)->nullable();
            $table->enum('business_type', ['sole_trader', 'partnership', 'company'])->default('company');
            
            // License Information
            $table->string('license_number')->unique();
            $table->string('license_holder_name');
            $table->date('license_expiry_date')->nullable();
            
            // Contact Information
            $table->text('business_address');
            $table->enum('state', ['NSW', 'VIC', 'QLD', 'WA', 'SA', 'TAS', 'ACT', 'NT']);
            $table->string('postcode', 4);
            $table->string('business_phone');
            $table->string('business_email')->unique();
            $table->string('website_url')->nullable();
            
            // Status & Verification
            $table->enum('status', ['pending', 'active', 'suspended', 'inactive'])->default('pending');
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');

            $table->foreignId('rejected_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('status');
            $table->index('state');
            $table->index('created_at');
        });

        // 2. Agency Contacts table (Section 2)
        Schema::create('agency_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('full_name');
            $table->string('position');
            $table->string('email');
            $table->string('phone');
            $table->string('mobile')->nullable();
            $table->boolean('is_primary')->default(false);
            
            // ID Verification
            $table->string('id_verification_type')->nullable(); // passport, driver_license
            $table->string('id_verification_number')->nullable();
            $table->string('id_verification_file')->nullable();
            $table->date('id_verification_expiry')->nullable();
            
            // Working With Children Check
            $table->string('wwcc_number')->nullable();
            $table->date('wwcc_expiry')->nullable();
            $table->string('wwcc_file')->nullable();
            
            $table->timestamps();
            
            $table->index('agency_id');
            $table->index('is_primary');
        });

        // 3. Agency Documents table (Section 4)
        Schema::create('agency_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            
            $table->enum('document_type', [
                'license_certificate',
                'proof_of_identity_passport',
                'proof_of_identity_driver_license',
                'abn_certificate',
                'insurance_professional_indemnity',
                'insurance_public_liability',
                'other'
            ]);
            $table->string('document_name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->integer('file_size')->nullable(); // in bytes
            
            // Verification
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Document expiry (for licenses, insurance, etc)
            $table->date('expiry_date')->nullable();
            
            $table->timestamps();
            
            $table->index('agency_id');
            $table->index('document_type');
            $table->index('status');
        });

        // 4. Agency Branding table (Section 5)
        Schema::create('agency_brandings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            
            $table->string('logo_path')->nullable();
            $table->string('brand_color', 7)->nullable(); // hex color
            $table->text('description')->nullable();
            
            // Social Media
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            
            // Office Hours (JSON format)
            // Example: {"monday": {"open": "09:00", "close": "17:00"}, ...}
            $table->json('office_hours')->nullable();
            
            $table->timestamps();
        });

        // 5. Agency Billing table (Section 6)
        Schema::create('agency_billing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            
            $table->string('billing_contact_name');
            $table->string('billing_email');
            $table->string('billing_phone');
            $table->text('billing_address')->nullable();
            
            // Payment method will be handled separately with payment gateway
            $table->string('payment_method')->nullable(); // card, direct_debit
            
            $table->timestamps();
        });

        // 6. Agency Services table (Section 7)
        Schema::create('agency_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            
            // Service Coverage (JSON array of suburbs/areas)
            $table->json('service_areas')->nullable();
            
            // Property Types
            $table->boolean('residential')->default(true);
            $table->boolean('commercial')->default(false);
            $table->boolean('rentals')->default(true);
            $table->boolean('sales')->default(true);
            $table->boolean('rural')->default(false);
            $table->boolean('industrial')->default(false);
            
            // Team Size
            $table->integer('number_of_agents')->default(0);
            $table->integer('number_of_employees')->default(0);
            
            $table->timestamps();
        });

        // 7. Agency Compliance table (Section 8)
        Schema::create('agency_compliances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            
            // Trust Account Details
            $table->string('trust_account_bsb', 6)->nullable();
            $table->string('trust_account_number')->nullable();
            $table->string('trust_account_name')->nullable();
            $table->string('trust_account_bank')->nullable();
            
            // Insurance Details
            $table->string('professional_indemnity_provider')->nullable();
            $table->string('professional_indemnity_policy_number')->nullable();
            $table->date('professional_indemnity_expiry')->nullable();
            
            $table->string('public_liability_provider')->nullable();
            $table->string('public_liability_policy_number')->nullable();
            $table->date('public_liability_expiry')->nullable();
            
            $table->timestamps();
        });

        // 8. Agency Settings table
        Schema::create('agency_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            
            $table->json('settings')->nullable();
            
            // Terms & Privacy
            $table->boolean('terms_accepted')->default(false);
            $table->timestamp('terms_accepted_at')->nullable();
            $table->ipAddress('terms_accepted_ip')->nullable();
            
            $table->boolean('privacy_accepted')->default(false);
            $table->timestamp('privacy_accepted_at')->nullable();
            $table->ipAddress('privacy_accepted_ip')->nullable();
            
            $table->timestamps();
        });

        // 9. Agents table (Section 9 - under agency)
       Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Basic Information
            $table->string('agent_code', 20)->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            
            // License & Professional Details
            $table->string('license_number', 50)->nullable();
            $table->date('license_expiry')->nullable();
            $table->string('position')->nullable(); // Sales Agent, Property Manager, etc.
            $table->enum('employment_type', ['full_time', 'part_time', 'contractor', 'intern'])->default('full_time');
            $table->decimal('commission_rate', 5, 2)->nullable()->comment('Percentage');
            
            // Profile
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->json('specializations')->nullable(); // ['Residential', 'Commercial', etc.]
            $table->json('languages')->nullable(); // ['English', 'Mandarin', etc.]
            $table->json('social_media')->nullable(); // {facebook: '', linkedin: '', etc.}
            
            // Address
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('suburb')->nullable();
            $table->string('state', 10)->nullable();
            $table->string('postcode', 10)->nullable();
            $table->string('country', 50)->default('Australia');
            
            // Emergency Contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            
            // Status & Dates
            $table->enum('status', ['active', 'inactive', 'on_leave', 'terminated'])->default('active');
            $table->boolean('is_active')->default(true);
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();
            
            // Features
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_accepting_new_listings')->default(true);
            
            // Metadata
            $table->json('metadata')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes
            $table->index(['agency_id', 'status']);
            $table->index('email');
            $table->index('license_number');
        });

        // 10. Update users table
        if (!Schema::hasColumn('users', 'agency_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('agency_id')->nullable()->after('email')->constrained()->onDelete('cascade');
                $table->string('phone')->nullable()->after('agency_id');
                $table->string('position')->nullable()->after('phone');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
        Schema::dropIfExists('agency_settings');
        Schema::dropIfExists('agency_compliances');
        Schema::dropIfExists('agency_services');
        Schema::dropIfExists('agency_billing');
        Schema::dropIfExists('agency_brandings');
        Schema::dropIfExists('agency_documents');
        Schema::dropIfExists('agency_contacts');
        Schema::dropIfExists('agencies');
        
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'agency_id')) {
                $table->dropForeign(['agency_id']);
                $table->dropColumn(['agency_id', 'phone', 'position']);
            }
        });
    }
};