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
        Schema::create('property_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            
            // Applicant Information
            $table->string('full_name');
            $table->string('email');
            $table->string('phone', 20);
            $table->string('current_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode', 10)->nullable();
            
            // Employment Information
            $table->string('employment_status')->nullable(); // employed, self-employed, unemployed, student, retired
            $table->string('employer_name')->nullable();
            $table->string('job_title')->nullable();
            $table->decimal('annual_income', 12, 2)->nullable();
            $table->integer('employment_length_months')->nullable();
            
            // References
            $table->string('reference_1_name')->nullable();
            $table->string('reference_1_phone')->nullable();
            $table->string('reference_1_relationship')->nullable();
            
            $table->string('reference_2_name')->nullable();
            $table->string('reference_2_phone')->nullable();
            $table->string('reference_2_relationship')->nullable();
            
            // Additional Information
            $table->integer('number_of_occupants')->nullable();
            $table->boolean('has_pets')->default(false);
            $table->string('pet_details')->nullable();
            $table->date('preferred_move_in_date')->nullable();
            $table->text('additional_notes')->nullable();
            
            // Documents
            $table->string('id_document_path')->nullable();
            $table->string('income_proof_path')->nullable();
            $table->string('reference_letter_path')->nullable();
            
            // Application Status
            $table->enum('status', [
                'pending',
                'reviewing',
                'approved',
                'rejected',
                'withdrawn'
            ])->default('pending');
            
            $table->text('agency_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Tracking
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['property_id', 'status']);
            $table->index('agency_id');
            $table->index('email');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_applications');
    }
};