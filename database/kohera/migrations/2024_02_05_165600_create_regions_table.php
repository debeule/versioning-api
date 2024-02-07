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
        Schema::create('SNS-Regio', function (Blueprint $table) {
            $table->id();
            $table->string('RegioNaam');
            $table->string('Provincie');
            $table->string('Postcode');
            $table->integer('RegioDetailId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
