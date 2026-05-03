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
        Schema::create('kkpo_brand', function (Blueprint $table) {
            //harusnya isinya kkpo_management_id dan brand_id, tapi perlu id gak? karena ini tabel pivot, biasanya gak perlu id, tapi kalau mau buat relasi one to many bisa ditambah id
            $table->id();
            $table->timestamps();
            $table->foreignId('kkpo_management_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kkpo_brand');
    }
};
