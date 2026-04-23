<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * UP → ubah jadi SET NULL
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('kkpo_managements', function (Blueprint $table) {

            // ubah jadi nullable
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

            // tambahin ulang FK (langsung overwrite)
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

    /**
     * DOWN → balik ke CASCADE + NOT NULL
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('kkpo_managements', function (Blueprint $table) {

            // ubah jadi NOT NULL
            $table->unsignedBigInteger('customer_id')->nullable(false)->change();
            $table->unsignedBigInteger('style_id')->nullable(false)->change();
            $table->unsignedBigInteger('color_id')->nullable(false)->change();
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
            $table->unsignedBigInteger('item_id')->nullable(false)->change();
            $table->unsignedBigInteger('unit_id')->nullable(false)->change();
            $table->unsignedBigInteger('currency_id')->nullable(false)->change();
            $table->unsignedBigInteger('brand_id')->nullable(false)->change();
        });

        Schema::table('kkpo_managements', function (Blueprint $table) {

            // tambahin ulang FK (langsung overwrite)
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->foreign('style_id')->references('id')->on('styles')->cascadeOnDelete();
            $table->foreign('color_id')->references('id')->on('colors')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete();
            $table->foreign('currency_id')->references('id')->on('currencies')->cascadeOnDelete();
            $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnDelete();
        });

        Schema::enableForeignKeyConstraints();
    }
};
