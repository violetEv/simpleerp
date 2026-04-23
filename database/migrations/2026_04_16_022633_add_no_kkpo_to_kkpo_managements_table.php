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
        Schema::table('kkpo_managements', function (Blueprint $table) {
            //tambah kolom no_kkpo
            $table->string('no_kkpo')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkpo_managements', function (Blueprint $table) {
            //hapus kolom no_kkpo
            $table->dropColumn('no_kkpo');
        });
    }
};
