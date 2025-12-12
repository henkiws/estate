<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Profile Status
            $table->enum('status', ['incomplete', 'pending', 'approved', 'rejected'])->default('incomplete');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable();
            
            // Step 1: Personal Details
            $table->string('title')->nullable(); // Mr, Mrs, Ms, Dr, etc
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('surname')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_country_code')->nullable();
            $table->string('mobile_number')->nullable();
            
            // Emergency Contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            $table->string('emergency_contact_country_code')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->string('emergency_contact_email')->nullable();
            
            // Guarantor
            $table->boolean('has_guarantor')->default(false);
            $table->string('guarantor_name')->nullable();
            $table->string('guarantor_country_code')->nullable();
            $table->string('guarantor_number')->nullable();
            $table->string('guarantor_email')->nullable();
            
            // Step 2: Introduction
            $table->text('introduction')->nullable();
            
            // Step 10: Terms and Conditions
            $table->boolean('terms_accepted')->default(false);
            $table->string('signature')->nullable();
            $table->timestamp('terms_accepted_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};