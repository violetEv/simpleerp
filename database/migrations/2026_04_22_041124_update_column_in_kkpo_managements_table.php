<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * UP → ubah ke RESTRICT
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('kkpo_managements', function (Blueprint $table) {
            // drop pakai COLUMN (Laravel resolve sendiri)
            $table->unsignedBigInteger('customer_id')->nullable()->change();
            $table->unsignedBigInteger('style_id')->nullable()->change();
            $table->unsignedBigInteger('color_id')->nullable()->change();
            $table->unsignedBigInteger('category_id')->nullable()->change();
            $table->unsignedBigInteger('item_id')->nullable()->change();
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->unsignedBigInteger('currency_id')->nullable()->change();
            $table->unsignedBigInteger('brand_id')->nullable()->change();
        });

        Schema::table('kkpo_managements', function (Blueprint $table) {
            // pasang RESTRICT
            $table->foreign('customer_id')->references('id')->on('customers')->restrictOnDelete();
            $table->foreign('style_id')->references('id')->on('styles')->restrictOnDelete();
            $table->foreign('color_id')->references('id')->on('colors')->restrictOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->restrictOnDelete();
            $table->foreign('item_id')->references('id')->on('items')->restrictOnDelete();
            $table->foreign('unit_id')->references('id')->on('units')->restrictOnDelete();
            $table->foreign('currency_id')->references('id')->on('currencies')->restrictOnDelete();
            $table->foreign('brand_id')->references('id')->on('brands')->restrictOnDelete();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('kkpo_managements', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable()->change();
            $table->unsignedBigInteger('style_id')->nullable()->change();
            $table->unsignedBigInteger('color_id')->nullable()->change();
            $table->unsignedBigInteger('category_id')->nullable()->change();
            $table->unsignedBigInteger('item_id')->nullable()->change();
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->unsignedBigInteger('currency_id')->nullable()->change();
            $table->unsignedBigInteger('brand_id')->nullable()->change();
        });

        Schema::table('kkpo_managements', function (Blueprint $table) {
            // balik ke NULL ON DELETE (kayak kondisi lo sebelumnya)
            $table->foreign('customer_id')->references('id')->on('customers')->nullOnDelete();
            $table->foreign('style_id')->references('id')->on('styles')->nullOnDelete();
            $table->foreign('color_id')->references('id')->on('colors')->nullOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
            $table->foreign('item_id')->references('id')->on('items')->nullOnDelete();
            $table->foreign('unit_id')->references('id')->on('units')->nullOnDelete();
            $table->foreign('currency_id')->references('id')->on('currencies')->nullOnDelete();
            $table->foreign('brand_id')->references('id')->on('brands')->nullOnDelete();
        });

        Schema::enableForeignKeyConstraints();
    }
};
