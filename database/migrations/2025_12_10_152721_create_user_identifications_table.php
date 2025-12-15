<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_identifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('identification_type', [
                'australian_drivers_licence',
                'passport',
                'birth_certificate',
                'medicare',
                'other'
            ]);
            $table->integer('points'); // 40, 40, 30, 20, 10
            $table->string('document_number')->nullable();
            $table->string('document_path');
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_identifications');
    }
};