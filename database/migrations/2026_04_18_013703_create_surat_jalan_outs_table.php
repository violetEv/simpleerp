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
        Schema::create('surat_jalan_outs', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat_jalan');
            $table->unsignedBigInteger('kkpo_management_id');
            $table->integer('qty');
            $table->date('tanggal');
            $table->text('notes')->nullable();
            // $table->string('status')->default('open');
            $table->foreign('kkpo_management_id')->references('id')->on('kkpo_managements')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_jalan_outs');
    }
};
