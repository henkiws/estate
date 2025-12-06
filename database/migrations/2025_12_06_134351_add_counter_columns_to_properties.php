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
        Schema::table('properties', function (Blueprint $table) {
            // Only add if columns don't exist
            if (!Schema::hasColumn('properties', 'view_count')) {
                $table->unsignedInteger('view_count')->default(0)->after('is_published');
            }
            
            if (!Schema::hasColumn('properties', 'enquiry_count')) {
                $table->unsignedInteger('enquiry_count')->default(0)->after('view_count');
            }
            
            if (!Schema::hasColumn('properties', 'inspection_count')) {
                $table->unsignedInteger('inspection_count')->default(0)->after('enquiry_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['view_count', 'enquiry_count', 'inspection_count']);
        });
    }
};