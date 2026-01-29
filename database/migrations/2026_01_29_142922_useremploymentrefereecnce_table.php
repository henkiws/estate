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
        // Add reference tracking fields to user_employments table
        Schema::table('user_employments', function (Blueprint $table) {
            $table->string('reference_token', 64)->nullable()->after('employment_letter_path');
            $table->enum('reference_status', ['pending', 'verified'])->default('pending')->after('reference_token');
            $table->timestamp('reference_email_sent_at')->nullable()->after('reference_status');
            $table->timestamp('reference_verified_at')->nullable()->after('reference_email_sent_at');
            
            $table->index('reference_token');
            $table->index('reference_status');
        });

        // Create employment references table to store manager responses
        Schema::create('user_employment_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_employment_id')->constrained('user_employments')->onDelete('cascade');
            
            // Questions and Answers
            $table->boolean('currently_works_there')->nullable();
            $table->string('current_works_there_comment')->nullable();
            
            $table->boolean('job_title_correct')->nullable();
            $table->string('job_title_comment')->nullable();
            
            $table->enum('employment_type', ['full_time', 'part_time', 'casual', 'contract', 'other'])->nullable();
            $table->string('employment_type_comment')->nullable();
            
            $table->date('actual_start_date')->nullable();
            $table->string('start_date_comment')->nullable();
            
            $table->decimal('annual_income', 10, 2)->nullable();
            $table->string('annual_income_comment')->nullable();
            
            $table->boolean('role_ongoing')->nullable();
            $table->string('role_ongoing_comment')->nullable();
            
            // Meta
            $table->string('referee_name')->nullable();
            $table->string('referee_email')->nullable();
            $table->string('referee_position')->nullable();
            $table->text('additional_comments')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->ipAddress('submitted_ip')->nullable();
            
            $table->timestamps();
            
            $table->index('submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_employment_references');
        
        Schema::table('user_employments', function (Blueprint $table) {
            $table->dropIndex(['reference_token']);
            $table->dropIndex(['reference_status']);
            $table->dropColumn([
                'reference_token',
                'reference_status',
                'reference_email_sent_at',
                'reference_verified_at',
            ]);
        });
    }
};