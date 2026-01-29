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
        Schema::table('user_identifications', function (Blueprint $table) {
            // Change single file column to JSON for multiple files
            $table->json('document_paths')->nullable()->after('document_number');
        });
        
        // Migrate existing data from old column to new JSON column
        DB::table('user_identifications')->whereNotNull('document_path')->get()->each(function ($identification) {
            DB::table('user_identifications')
                ->where('id', $identification->id)
                ->update([
                    'document_paths' => json_encode([$identification->document_path]),
                ]);
        });
        
        Schema::table('user_identifications', function (Blueprint $table) {
            // Drop old single file column
            $table->dropColumn('document_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_identifications', function (Blueprint $table) {
            // Add back old column
            $table->string('document_path')->nullable()->after('document_number');
        });
        
        // Migrate data back (take first file from JSON array)
        DB::table('user_identifications')->whereNotNull('document_paths')->get()->each(function ($identification) {
            $paths = json_decode($identification->document_paths, true);
            DB::table('user_identifications')
                ->where('id', $identification->id)
                ->update([
                    'document_path' => $paths[0] ?? null,
                ]);
        });
        
        Schema::table('user_identifications', function (Blueprint $table) {
            // Drop JSON column
            $table->dropColumn('document_paths');
        });
    }
};