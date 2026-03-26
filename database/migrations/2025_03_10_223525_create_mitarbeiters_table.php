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
        Schema::create('mitarbeiters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('dienstnummer');
            $table->bigInteger('dienstgrad');
            $table->timestamp('naechste_befoerderung');
            $table->string('arbeitsverhaltnis');
            $table->string('geburtsdatum');
            $table->string('geschlecht');
            $table->bigInteger('telefonnummer');
            $table->string('iban');
            $table->boolean('zulassung_nebenjob');
            $table->string('nebenjob');
            $table->string('nebenjob_von');
            $table->string('baeamtenstatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitarbeiters');
    }
};
