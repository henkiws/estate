<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to modify ENUM column to include all status values
        DB::statement("ALTER TABLE `user_profiles` 
            MODIFY COLUMN `status` ENUM('draft', 'pending', 'approved', 'rejected') 
            DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original ENUM (assuming it was just 'pending', 'approved', 'rejected')
        DB::statement("ALTER TABLE `user_profiles` 
            MODIFY COLUMN `status` ENUM('pending', 'approved', 'rejected') 
            DEFAULT 'pending'");
    }
};