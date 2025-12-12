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
        Schema::table('user_profiles', function (Blueprint $table) {
            // Check and add missing columns
            if (!Schema::hasColumn('user_profiles', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable()->after('status');
            }
            
            if (!Schema::hasColumn('user_profiles', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('submitted_at');
            }
            
            if (!Schema::hasColumn('user_profiles', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('approved_at');
            }
            
            if (!Schema::hasColumn('user_profiles', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->after('rejected_at')->constrained('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('user_profiles', 'rejected_by')) {
                $table->foreignId('rejected_by')->nullable()->after('approved_by')->constrained('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('user_profiles', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('rejected_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['rejected_by']);
            
            $table->dropColumn([
                'submitted_at',
                'approved_at',
                'rejected_at',
                'approved_by',
                'rejected_by',
                'rejection_reason'
            ]);
        });
    }
};