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
        Schema::create('municipalities', function (Blueprint $table) {
            $table->id();
            $table->int('municipality_id');
            
            $table->string('name');
            $table->integer('postal_code');
            $table->enum('province', ['antwerpen', 'limburg', 'oost-vlaanderen', 'vlaams-brabant', 'west-vlaanderen']); 
            $table->string('head_municipality')->nullable();

            $table->date('deleted_at')->nullable();

            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipalities');
    }
};
