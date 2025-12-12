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
        Schema::create('user_profile_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_profile_id')->constrained('user_profiles')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // The user whose profile this is
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); // Admin who performed action
            
            $table->enum('action', ['submitted', 'approved', 'rejected', 'updated']); // Action type
            $table->enum('previous_status', ['draft', 'pending', 'approved', 'rejected'])->nullable();
            $table->enum('new_status', ['draft', 'pending', 'approved', 'rejected']);
            
            $table->text('reason')->nullable(); // Rejection reason or approval notes
            $table->text('admin_notes')->nullable(); // Private admin notes
            $table->json('changes')->nullable(); // Store what fields were changed (for updates)
            
            $table->string('ip_address', 45)->nullable(); // IP address of admin
            $table->string('user_agent')->nullable(); // Browser/device info
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_profile_id');
            $table->index('user_id');
            $table->index('admin_id');
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profile_histories');
    }
};