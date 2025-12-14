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
        Schema::create('application_drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->nullable()->constrained()->onDelete('set null');
            
            // Property details (if property is deleted, we keep the address)
            $table->string('property_address')->nullable();
            $table->string('property_code')->nullable();
            
            // Draft data
            $table->json('form_data')->nullable(); // Store partial application data
            $table->integer('current_step')->default(1); // Which step user is on (1-10)
            $table->integer('total_steps')->default(10);
            
            // Status
            $table->enum('status', ['draft', 'abandoned', 'converted'])->default('draft');
            
            // Metadata
            $table->timestamp('last_edited_at')->useCurrent();
            $table->timestamp('expires_at')->nullable(); // Auto-delete old drafts after 30 days
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('status');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_drafts');
    }
};