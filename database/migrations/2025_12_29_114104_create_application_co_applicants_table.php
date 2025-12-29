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
        Schema::create('application_co_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_application_id')->constrained('property_applications')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->date('date_of_birth');
            $table->string('relationship_to_applicant')->nullable()->comment('e.g., spouse, partner, roommate');
            $table->string('employment_status')->nullable();
            $table->string('employer_name')->nullable();
            $table->decimal('annual_income', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_co_applicants');
    }
};