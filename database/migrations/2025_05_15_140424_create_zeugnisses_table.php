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
        Schema::create('zeugnisses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ausbildung');
            $table->string('bezeichnung');
            $table->bigInteger('user_id');
            $table->string('name');
            $table->string('geburtsdatum');
            $table->string('ausbilder');
            $table->date('datum')->default(now());
            $table->date('datum2')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zeugnisses');
    }
};
