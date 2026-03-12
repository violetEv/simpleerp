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
        Schema::create('travelers', function (Blueprint $table) {
            $table->id();
            $table->string('no_traveler')->unique();
            $table->foreignId('kkpo_id')->constrained('kkpos')->onDelete('cascade');
            $table->foreignId('current_dept_id')->nullable()->constrained('departments');
            $table->enum('status', ['open','in_process','done'])->default('open');
            $table->foreignId('parent_traveler_id')->nullable()->constrained('travelers')->onDelete('cascade'); // untuk split traveler
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travelers');
    }
};
