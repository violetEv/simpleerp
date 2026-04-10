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
                $table->renameColumn('kkpo_id', 'kkpo_management_id');
                $table->foreign('kkpo_management_id')->references('id')->on('kkpo_managements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_jalans', function (Blueprint $table) {
            $table->dropForeign(['kkpo_management_id']);
            $table->renameColumn('kkpo_management_id', 'kkpo_id');
        });
    }
};
