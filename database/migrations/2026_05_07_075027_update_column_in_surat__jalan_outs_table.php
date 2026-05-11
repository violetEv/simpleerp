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
            //ubah kolom kkpo_management_id menjadi surat_jalan_in_id
            $table->dropForeign(['kkpo_management_id']);
            $table->dropColumn('kkpo_management_id');
            $table->unsignedBigInteger('surat_jalan_in_id')->after('id');
            $table->foreign('surat_jalan_in_id')->references('id')->on('surat_jalans')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_jalan_outs', function (Blueprint $table) {
            //
                $table->dropForeign(['surat_jalan_in_id']);
            $table->dropColumn('surat_jalan_in_id');
            $table->unsignedBigInteger('kkpo_management_id')->after('id');
            $table->foreign('kkpo_management_id')->references('id')->on('kkpo_managements')->onDelete('cascade');
        });
    }
};
