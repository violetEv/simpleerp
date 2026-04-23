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
            // tambah kolom item_id, brand_id, unit_id, set null setelah colors. diambil dari tabel items, brands, units. foreignkey
            $table->unsignedBigInteger('item_id')->nullable()->after('color_id');
            $table->unsignedBigInteger('brand_id')->nullable()->after('item_id');
            $table->unsignedBigInteger('unit_id')->nullable()->after('brand_id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkpo_managements', function (Blueprint $table) {
            // hapus kolom item_id, brand_id, unit_id
            $table->dropForeign(['item_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['unit_id']);
            $table->dropColumn('item_id');
            $table->dropColumn('brand_id');
            $table->dropColumn('unit_id');

        });
    }
};
