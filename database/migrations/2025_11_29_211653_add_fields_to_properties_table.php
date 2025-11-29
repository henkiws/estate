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
            // Add floorplan field
            if (!Schema::hasColumn('properties', 'floorplan_path')) {
                $table->string('floorplan_path')->nullable()->after('description');
            }
            
            // Add bond weeks field for dynamic calculation
            if (!Schema::hasColumn('properties', 'bond_weeks')) {
                $table->integer('bond_weeks')->default(4)->after('rent_per_month');
            }
            
            // Add public listing URL slug/code
            if (!Schema::hasColumn('properties', 'public_url_code')) {
                $table->string('public_url_code', 50)->unique()->nullable()->after('slug');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'floorplan_path')) {
                $table->dropColumn('floorplan_path');
            }
            if (Schema::hasColumn('properties', 'bond_weeks')) {
                $table->dropColumn('bond_weeks');
            }
            if (Schema::hasColumn('properties', 'public_url_code')) {
                $table->dropColumn('public_url_code');
            }
        });
    }
};