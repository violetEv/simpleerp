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
            //hapus kolom  dan fk: unit_id, currency_id, price, remark, reject_allowance, qty_total dari tabel kkpo_managements
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['currency_id']);
            $table->dropColumn(['unit_id', 'currency_id', 'price', 'remark', 'reject_allowance', 'qty_total']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkpo_managements', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->text('remark')->nullable();
            $table->decimal('reject_allowance', 15, 2)->nullable();
            $table->integer('qty_total')->nullable();

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
    }
};
