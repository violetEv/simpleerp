<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kkpo_managements', function (Blueprint $table) {

            // ================= STYLE =================
            $table->dropForeign('kkpos_style_id_foreign');
            $table->unsignedBigInteger('style_id')->nullable()->change();
            $table->foreign('style_id')
                ->references('id')
                ->on('styles')
                ->nullOnDelete();

            // ================= COLOR =================
            $table->dropForeign('kkpos_color_id_foreign');
            $table->unsignedBigInteger('color_id')->nullable()->change();
            $table->foreign('color_id')
                ->references('id')
                ->on('colors')
                ->nullOnDelete();

            // ================= CATEGORY =================
            $table->dropForeign('kkpos_category_id_foreign');
            $table->unsignedBigInteger('category_id')->nullable()->change();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('kkpo_managements', function (Blueprint $table) {

            // STYLE balik ke restrict/cascade (bebas lo mau apa)
            $table->dropForeign(['style_id']);
            $table->unsignedBigInteger('style_id')->nullable(false)->change();
            $table->foreign('style_id')
                ->references('id')
                ->on('styles')
                ->restrictOnDelete();

            // COLOR
            $table->dropForeign(['color_id']);
            $table->unsignedBigInteger('color_id')->nullable(false)->change();
            $table->foreign('color_id')
                ->references('id')
                ->on('colors')
                ->restrictOnDelete();

            // CATEGORY
            $table->dropForeign(['category_id']);
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->restrictOnDelete();
        });
    }
};