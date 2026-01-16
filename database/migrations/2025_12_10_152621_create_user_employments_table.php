<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_employments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->text('address');
            $table->string('position');
            $table->decimal('gross_annual_salary', 12, 2);
            $table->string('manager_full_name');
            $table->string('contact_country_code');
            $table->string('contact_number');
            $table->string('email');
            $table->string('employment_letter_path')->nullable();
            $table->date('start_date');
            $table->boolean('still_employed')->default(true);
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_employments');
    }
};