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
        Schema::create('property_enquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            
            // Enquirer details
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20);
            $table->text('message');
            
            // Status tracking
            $table->enum('status', ['new', 'replied', 'closed'])->default('new');
            
            // Agency response (optional)
            $table->text('agency_reply')->nullable();
            $table->timestamp('replied_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('property_id');
            $table->index('agency_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_enquiries');
    }
};