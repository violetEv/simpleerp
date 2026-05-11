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
        Schema::table('kkpo_details', function (Blueprint $table) {
            //tambah kolom tanggal
            $table->date('date')->nullable()->after('kkpo_management_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkpo_details', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }
};
