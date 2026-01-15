<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('user_pets', function (Blueprint $table) {
            $table->string('photo_path')->nullable()->after('document_path');
        });
    }

    public function down()
    {
        Schema::table('user_pets', function (Blueprint $table) {
            $table->dropColumn('photo_path');
        });
    }
};
