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
            //ubah kolom dept_id menjadi current_dept_id
            $table->renameColumn('dept_id', 'current_dept_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traveler_movements', function (Blueprint $table) {
            //ubah kolom current_dept_id menjadi dept_id
            $table->renameColumn('current_dept_id', 'dept_id');
        });
    }
};
