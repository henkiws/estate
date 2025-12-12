<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('vehicle_type', ['car', 'motorcycle']);
            $table->string('year');
            $table->string('make');
            $table->string('model');
            $table->string('state');
            $table->string('registration_number');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_vehicles');
    }
};