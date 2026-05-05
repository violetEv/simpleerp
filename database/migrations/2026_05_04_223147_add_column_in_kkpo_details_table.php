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
            //tambah kolom curreny_id, reject_allowance
            $table->unsignedBigInteger('currency_id')->nullable()->after('unit_id');
            $table->decimal('reject_allowance', 15, 2)->nullable()->after('remark');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkpo_details', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropColumn(['currency_id', 'reject_allowance']);

            
        });
    }
};
