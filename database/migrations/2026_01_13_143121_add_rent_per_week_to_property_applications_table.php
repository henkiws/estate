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
            $table->decimal('rent_per_week', 10, 2)->nullable()->after('annual_income');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_applications', function (Blueprint $table) {
            $table->dropColumn('rent_per_week');
        });
    }
};