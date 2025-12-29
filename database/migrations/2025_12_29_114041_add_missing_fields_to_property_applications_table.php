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
            // Add inspection fields
            $table->boolean('inspection_confirmed')->default(false)->after('property_id');
            $table->date('inspection_date')->nullable()->after('inspection_confirmed');
            
            // Add lease duration (in months)
            $table->integer('lease_duration')->nullable()->comment('Preferred lease duration in months')->after('move_in_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_applications', function (Blueprint $table) {
            $table->dropColumn([
                'inspection_confirmed',
                'inspection_date',
                'lease_duration'
            ]);
        });
    }
};