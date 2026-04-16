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
        Schema::table('surat_jalans', function (Blueprint $table) {
            // hapus unique index
            $table->dropUnique(['no_surat_jalan']);

            // ubah kolom (optional: jadi nullable)
            $table->string('no_surat_jalan')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('surat_jalans', function (Blueprint $table) {
            // balikin ke tidak nullable
            $table->string('no_surat_jalan')->nullable(false)->change();

            // tambahin unique lagi
            $table->unique('no_surat_jalan');
        });
    }
};
