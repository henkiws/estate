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
            // Add property inspection fields after lease_term
            $table->enum('property_inspection', ['yes', 'no'])
                  ->after('lease_term')
                  ->nullable()
                  ->comment('Whether applicant has inspected the property');
            
            $table->date('inspection_date')
                  ->after('property_inspection')
                  ->nullable()
                  ->comment('Date when property was inspected (if applicable)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_applications', function (Blueprint $table) {
            $table->dropColumn(['property_inspection', 'inspection_date']);
        });
    }
};