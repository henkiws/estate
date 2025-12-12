<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('living_arrangement', [
                'owner',
                'renting_agent',
                'renting_privately',
                'with_parents',
                'sharing',
                'other'
            ]);
            $table->text('address');
            $table->integer('years_lived')->default(0);
            $table->integer('months_lived')->default(0);
            $table->text('reason_for_leaving')->nullable();
            $table->boolean('different_postal_address')->default(false);
            $table->string('postal_code')->nullable();
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};