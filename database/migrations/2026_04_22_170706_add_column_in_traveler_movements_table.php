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
            //tambah kolom created_by dan updated_by
            $table->unsignedBigInteger('created_by')->nullable()->after('dept_asal_id');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traveler_movements', function (Blueprint $table) {
            //hapus kolom created_by dan updated_by
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');

        });
    }
};
