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
            // tambah kolom alamat, driver, kendaraan, dan status
             $table->string('alamat')->nullable();
             $table->string('driver')->nullable();
             $table->string('kendaraan')->nullable();
             $table->string('status')->default('ready_to_send'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_jalan_outs', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'driver', 'kendaraan', 'status']);
        });
    }
};
