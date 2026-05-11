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
        Schema::table('surat_jalan_outs', function (Blueprint $table) {
            //hapus kolom alamat, driver, kendaraan
            $table->dropColumn(['alamat', 'driver', 'kendaraan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_jalan_outs', function (Blueprint $table) {
            //
            $table->string('alamat')->nullable();
            $table->string('driver')->nullable();
            $table->string('kendaraan')->nullable();
        });
    }
};
