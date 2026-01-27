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
        Schema::table('user_addresses', function (Blueprint $table) {
            // Add owned_property field (1 = Yes/Owned, 0 = No/Rented)
            $table->boolean('owned_property')->default(true)->after('living_arrangement');
            
            // Reference fields (only filled when owned_property = 0)
            $table->string('reference_full_name')->nullable()->after('owned_property');
            $table->string('reference_email')->nullable()->after('reference_full_name');
            $table->string('reference_country_code')->nullable()->after('reference_email');
            $table->string('reference_phone', 20)->nullable()->after('reference_country_code');
            
            // Reference verification tracking
            $table->boolean('reference_verified')->default(false)->after('reference_phone');
            $table->timestamp('reference_verified_at')->nullable()->after('reference_verified');
            $table->string('reference_token')->nullable()->unique()->after('reference_verified_at');
            $table->timestamp('reference_email_sent_at')->nullable()->after('reference_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropColumn([
                'owned_property',
                'reference_full_name',
                'reference_email',
                'reference_country_code',
                'reference_phone',
                'reference_verified',
                'reference_verified_at',
                'reference_token',
                'reference_email_sent_at',
            ]);
        });
    }
};