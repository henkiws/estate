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
        Schema::create('property_agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('agent_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['listing_agent', 'property_manager', 'co_agent'])->default('listing_agent');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // Ensure unique combination
            $table->unique(['property_id', 'agent_id']);
            
            // Indexes
            $table->index('property_id');
            $table->index('agent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_agents');
    }
};