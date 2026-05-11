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
            //tambah kkpo_detail_id di surat_jalans
            $table->unsignedBigInteger('kkpo_detail_id')->nullable()->after('id');
            $table->foreign('kkpo_detail_id')->references('id')->on('kkpo_details')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_jalans', function (Blueprint $table) {
            $table->dropForeign(['kkpo_detail_id']);
            $table->dropColumn('kkpo_detail_id');
        });
    }
};
