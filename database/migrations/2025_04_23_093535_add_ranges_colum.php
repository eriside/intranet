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
        Schema::table('raenges', function (Blueprint $table) {
            $table->bigInteger('discord_id');
            $table->bigInteger('gehalt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raenges', function (Blueprint $table) {
            $table->dropColumn('discord_id');
            $table->dropColumn('gehalt');
        });
    }
};
