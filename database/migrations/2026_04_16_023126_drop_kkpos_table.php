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
        Schema::dropIfExists('kkpos');
    }

    public function down(): void
    {
        Schema::create('kkpos', function (Blueprint $table) {
            $table->id();
            $table->string('no_kkpo');
            $table->timestamps();
        });
    }
};
