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
            $table->string('name');
            $table->string('email');
            $table->enum('type', ['KO','LO', 'SO']);
            $table->string('school_id');
            $table->date('deleted_at')->nullable();
            $table->unsignedBigInteger('institution_id');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('contact_id')->references('id')->on('contact');
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
