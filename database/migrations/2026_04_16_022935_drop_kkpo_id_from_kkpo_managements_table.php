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
            // drop foreign key dulu
            $table->dropForeign(['kkpo_id']);

            // lalu drop kolom
            $table->dropColumn('kkpo_id');
        });
    }

    public function down(): void
    {
        Schema::table('kkpo_managements', function (Blueprint $table) {
            $table->unsignedBigInteger('kkpo_id')->nullable();

            $table->foreign('kkpo_id')
                ->references('id')
                ->on('kkpos')
                ->onDelete('cascade');
        });
    }
};
