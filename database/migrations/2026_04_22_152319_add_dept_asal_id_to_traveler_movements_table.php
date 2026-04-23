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
            //tambah kolom dept_asal_id
            $table->foreignId('dept_asal_id')->nullable()->constrained('departments')->after('date_out');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traveler_movements', function (Blueprint $table) {
            //hapus kolom dept_asal_id
            $table->dropForeign(['dept_asal_id']);
            $table->dropColumn('dept_asal_id');
            
        });
    }
};
