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
        Schema::create('property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type', 50);
            $table->integer('file_size'); // in bytes
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            
            $table->string('title')->nullable();
            $table->text('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            
            $table->timestamps();
            
            // Indexes
            $table->index(['property_id', 'sort_order']);
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_images');
    }
};