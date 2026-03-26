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
            $table->bigInteger('next_rang');
            $table->bigInteger('time_till');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raenges', function (Blueprint $table) {
            $table->dropColumn('time_till');
            $table->dropColumn('next_rang');
        });
    }
};
