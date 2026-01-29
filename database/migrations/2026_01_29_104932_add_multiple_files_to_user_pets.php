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
        Schema::table('user_pets', function (Blueprint $table) {
            // Change single file columns to JSON for multiple files
            $table->json('photo_paths')->nullable()->after('registration_number');
            $table->json('document_paths')->nullable()->after('photo_paths');
        });
        
        // Migrate existing data from old columns to new JSON columns
        DB::table('user_pets')->whereNotNull('photo_path')->get()->each(function ($pet) {
            DB::table('user_pets')
                ->where('id', $pet->id)
                ->update([
                    'photo_paths' => json_encode([$pet->photo_path]),
                ]);
        });
        
        DB::table('user_pets')->whereNotNull('document_path')->get()->each(function ($pet) {
            DB::table('user_pets')
                ->where('id', $pet->id)
                ->update([
                    'document_paths' => json_encode([$pet->document_path]),
                ]);
        });
        
        Schema::table('user_pets', function (Blueprint $table) {
            // Drop old single file columns
            $table->dropColumn(['photo_path', 'document_path']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_pets', function (Blueprint $table) {
            // Add back old columns
            $table->string('photo_path')->nullable()->after('registration_number');
            $table->string('document_path')->nullable()->after('photo_path');
        });
        
        // Migrate data back (take first file from JSON array)
        DB::table('user_pets')->whereNotNull('photo_paths')->get()->each(function ($pet) {
            $paths = json_decode($pet->photo_paths, true);
            DB::table('user_pets')
                ->where('id', $pet->id)
                ->update([
                    'photo_path' => $paths[0] ?? null,
                ]);
        });
        
        DB::table('user_pets')->whereNotNull('document_paths')->get()->each(function ($pet) {
            $paths = json_decode($pet->document_paths, true);
            DB::table('user_pets')
                ->where('id', $pet->id)
                ->update([
                    'document_path' => $paths[0] ?? null,
                ]);
        });
        
        Schema::table('user_pets', function (Blueprint $table) {
            // Drop JSON columns
            $table->dropColumn(['photo_paths', 'document_paths']);
        });
    }
};