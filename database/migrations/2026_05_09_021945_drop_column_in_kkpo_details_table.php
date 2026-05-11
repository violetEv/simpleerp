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
            //hapus kolom currency_id dan fk constraintnya
            $table->dropForeign(['currency_id']);
            $table->dropColumn('currency_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkpo_details', function (Blueprint $table) {
            //tambahkan kembali kolom currency_id dan fknya
            $table->unsignedBigInteger('currency_id')->nullable()->after('remark');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
    }
};
