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
        Schema::table('traveler_movements', function (Blueprint $table) {
            //tambah kolom status_case untuk menandai apakah movement ini normal, selisih, string aja
            $table->string('status_case')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traveler_movements', function (Blueprint $table) {
            $table->dropColumn('status_case');
        });
    }
};
