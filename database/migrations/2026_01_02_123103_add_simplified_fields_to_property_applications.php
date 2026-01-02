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
        Schema::table('property_applications', function (Blueprint $table) {
            // Add new simplified fields
            $table->integer('lease_term')->nullable()->after('lease_duration')->comment('Lease term in months (1-24)');
            $table->json('occupants_details')->nullable()->after('number_of_occupants')->comment('Additional occupants details');
            $table->text('special_requests')->nullable()->after('occupants_details');
            $table->text('notes')->nullable()->after('special_requests');
            
            // Add status field if it doesn't exist (for draft status)
            // Check if status column doesn't have 'draft' option
            DB::statement("ALTER TABLE property_applications MODIFY COLUMN status ENUM('draft', 'pending', 'under_review', 'approved', 'rejected', 'withdrawn') DEFAULT 'draft'");
            
            // Add reviewer tracking
            $table->foreignId('reviewed_by')->nullable()->after('reviewed_at')->constrained('users')->onDelete('set null');
            $table->timestamp('withdrawn_at')->nullable()->after('reviewed_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_applications', function (Blueprint $table) {
            $table->dropColumn([
                'lease_term',
                'occupants_details',
                'special_requests',
                'notes',
                'reviewed_by',
                'withdrawn_at'
            ]);
            
            // Revert status enum (only if needed)
            DB::statement("ALTER TABLE property_applications MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'withdrawn') DEFAULT 'pending'");
        });
    }
};