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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            
            // Application status
            $table->enum('status', ['pending', 'approved', 'rejected', 'withdrawn'])->default('pending');
            
            // Personal Details
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone', 20);
            $table->date('date_of_birth')->nullable();
            $table->text('current_address');
            
            // Move-in details
            $table->date('move_in_date');
            $table->integer('number_of_occupants')->default(1);
            $table->boolean('has_pets')->default(false);
            $table->text('pet_details')->nullable();
            
            // Employment Information
            $table->enum('employment_status', ['employed', 'self_employed', 'student', 'retired', 'unemployed']);
            $table->string('employer_name')->nullable();
            $table->string('job_title')->nullable();
            $table->decimal('annual_income', 12, 2);
            
            // References (stored as JSON array)
            $table->json('references')->nullable();
            
            // Additional Information
            $table->text('additional_information')->nullable();
            
            // Documents (optional uploads - stored as JSON array of file paths)
            $table->json('documents')->nullable();
            
            // Agency notes/feedback
            $table->text('agency_notes')->nullable();
            
            // Timestamps
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('user_id');
            $table->index('property_id');
            $table->index('agency_id');
            $table->index('status');
            $table->index('submitted_at');
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