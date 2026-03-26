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
        Schema::create('aktuelles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('einsatzNummer');
            $table->string('einsatzStichwort');
            $table->json('einsatzLage');
            $table->string('author');
            $table->json('eingesetzteFahrzeuge');
            $table->string('einsatzBild');
            $table->string('datum');
            $table->string("uhrzeit");
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktuelles');
    }
};
