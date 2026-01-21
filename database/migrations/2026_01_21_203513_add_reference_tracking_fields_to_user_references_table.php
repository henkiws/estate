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
        Schema::table('user_references', function (Blueprint $table) {
            $table->string('reference_token')->nullable()->unique()->after('email');
            $table->timestamp('token_expires_at')->nullable()->after('reference_token');
            $table->timestamp('reference_submitted_at')->nullable()->after('token_expires_at');
            $table->text('reference_response')->nullable()->after('reference_submitted_at');
            $table->enum('reference_status', ['pending', 'completed', 'expired'])->default('pending')->after('reference_response');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_references', function (Blueprint $table) {
            $table->dropColumn([
                'reference_token',
                'token_expires_at',
                'reference_submitted_at',
                'reference_response',
                'reference_status',
            ]);
        });
    }
};