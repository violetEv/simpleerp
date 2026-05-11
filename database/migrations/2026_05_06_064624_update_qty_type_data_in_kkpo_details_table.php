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
            //ubah tipe data qty menjadi integer
            $table->integer('qty')->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkpo_details', function (Blueprint $table) {
            //ubah tipe data qty menjadi decimal(10,2)
            $table->decimal('qty', 10, 2)->change();
        });
    }
};
