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
            // Add reference_status field after reference_verified_at
            $table->enum('reference_status', ['pending', 'verified'])->nullable()->after('reference_verified_at');
            
            $table->index('reference_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropIndex(['reference_status']);
            $table->dropColumn('reference_status');
        });
    }
};