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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->integer('place_id');
            $table->string('Name');
            $table->string('Gangmaker_mail');
            $table->string('School_mail');
            $table->string('address');
            $table->integer('Student_Count');
            $table->integer('School_Id');
            $table->integer('Instellingsnummer');
            $table->integer('Postcode');
            $table->string('Gemeente');
            $table->string('Type');
            $table->string('Facturatie_Naam');
            $table->string('Facturatie_Tav');
            $table->string('Facturatie_Adres');
            $table->string('Facturatie_Postcode');
            $table->string('Facturatie_Gemeente');
            $table->string('BTWNummer');
            $table->string('Facturatie_Email');
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
