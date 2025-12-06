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
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email');
            $table->string('phone', 20);
            
            // Application Details
            $table->date('move_in_date');
            $table->string('current_address');
            $table->enum('employment_status', ['employed', 'self_employed', 'student', 'retired', 'unemployed']);
            $table->string('employer_name')->nullable();
            $table->decimal('annual_income', 12, 2);
            $table->integer('number_of_occupants');
            
            // Pet Information
            $table->boolean('has_pets')->default(false);
            $table->text('pet_details')->nullable();
            
            // References (stored as JSON array)
            $table->json('references')->nullable();
            
            // Additional Information
            $table->text('additional_information')->nullable();
            
            // Application Status
            $table->enum('status', ['pending', 'reviewing', 'approved', 'rejected'])->default('pending');
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('rejection_reason')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['property_id', 'status']);
            $table->index(['agency_id', 'status']);
            $table->index('email');
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