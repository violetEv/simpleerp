<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('travelers', function (Blueprint $table) {

            $table->dropForeign(['kkpo_id']);
            $table->dropColumn('kkpo_id');

            $table->foreignId('surat_jalan_id')
                  ->after('no_traveler')
                  ->constrained('surat_jalans')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('travelers', function (Blueprint $table) {

            $table->dropForeign(['surat_jalan_id']);
            $table->dropColumn('surat_jalan_id');

            $table->foreignId('kkpo_id')
                  ->constrained('kkpos')
                  ->onDelete('cascade');
        });
    }
};