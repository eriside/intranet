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
        Schema::create('mitarbeiterkatschutzs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('vorname');
            $table->string('geburtsdatum');
            $table->string('geschlecht');
            $table->bigInteger('telefonnummer');
            $table->string('iban');
            $table->string('email');
            $table->string('führerscheinklassen');
            $table->boolean('aktiv')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitarbeiterkatschutzs');
    }
};
