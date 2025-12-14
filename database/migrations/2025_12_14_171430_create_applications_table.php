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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            
            // Application Status
            $table->enum('status', [
                'draft',
                'submitted',
                'under_review',
                'approved',
                'rejected',
                'withdrawn'
            ])->default('draft');
            
            // Application Details
            $table->date('move_in_date');
            $table->integer('lease_term')->comment('Lease term in months');
            $table->integer('number_of_occupants')->default(1);
            $table->json('occupants_details')->nullable()->comment('Details of additional occupants');
            
            // Additional Information
            $table->text('special_requests')->nullable();
            $table->text('notes')->nullable();
            
            // Admin Notes (not visible to user)
            $table->text('admin_notes')->nullable();
            
            // Status Timestamps
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('withdrawn_at')->nullable();
            
            // Rejection Details
            $table->text('rejection_reason')->nullable();
            
            // Standard Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('property_id');
            $table->index('status');
            $table->index('submitted_at');
            
            // Unique constraint: User can only have one active application per property
            $table->unique(['user_id', 'property_id', 'status'], 'unique_active_application');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};