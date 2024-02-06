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
        Schema::create('billing_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('school_id');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign('address_id')->references('id')->on('addresses');
        });
        
        Schema::table('schools', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_profiles');
    }
};
