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
        Schema::create('SNS-Sport', function (Blueprint $table) {
            $table->id();
            $table->string('Sportkeuze');
            $table->string('BK_SportTakSportOrganisatie');
            $table->string('Sport');
            $table->string('Hoofdsport');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sports');
    }
};
