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
        Schema::table('travelers', function (Blueprint $table) {
            //tambah kolom pic /attention
            $table->string('pic')->nullable()->after('no_traveler'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travelers', function (Blueprint $table) {
            //hapus kolom pic /attention
            $table->dropColumn('pic');
        });
    }
};
