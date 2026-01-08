<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_code')->unique()->comment('Unique tenant identifier');
            
            // Foreign Keys
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('Links to User who applied');
            $table->foreignId('property_id')->constrained()->onDelete('cascade')->comment('Current property');
            $table->foreignId('agency_id')->constrained()->onDelete('cascade')->comment('Managing agency');
            $table->foreignId('application_id')->nullable()->constrained('property_applications')->onDelete('set null')->comment('Original application');
            
            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            
            // Lease Information
            $table->date('lease_start_date');
            $table->date('lease_end_date');
            $table->integer('lease_term_months');
            $table->decimal('rent_amount', 10, 2)->comment('Rent amount per payment period');
            $table->enum('payment_frequency', ['weekly', 'fortnightly', 'monthly'])->default('monthly');
            $table->date('next_payment_due')->nullable();
            
            // Bond Information
            $table->decimal('bond_amount', 10, 2)->default(0);
            $table->boolean('bond_paid')->default(false);
            $table->date('bond_paid_date')->nullable();
            $table->string('bond_reference')->nullable()->comment('Bond lodgement reference');
            
            // Status
            $table->enum('status', ['pending_move_in', 'active', 'notice_given', 'ending', 'ended'])->default('pending_move_in');
            $table->date('notice_given_date')->nullable();
            $table->date('intended_vacate_date')->nullable();
            
            // Emergency Contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            
            // Additional Occupants (JSON)
            $table->json('additional_occupants')->nullable()->comment('Other people living in property');
            
            // Move in/out tracking
            $table->date('moved_in_at')->nullable();
            $table->date('moved_out_at')->nullable();
            $table->timestamp('lease_signed_at')->nullable();
            
            // Notes and Documents
            $table->text('notes')->nullable();
            $table->json('documents')->nullable()->comment('Lease agreements, inspection reports, etc.');
            
            // Metadata
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('tenant_code');
            $table->index('status');
            $table->index(['agency_id', 'status']);
            $table->index('lease_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};