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
        Schema::create('traveler_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('traveler_id')->constrained('travelers')->onDelete('cascade');
            $table->foreignId('dept_id')->constrained('departments');
            $table->integer('qty_in')->default(0);
            $table->integer('qty_out')->default(0);
            $table->dateTime('date_in')->nullable();
            $table->dateTime('date_out')->nullable();
            $table->foreignId('dept_destination_id')->nullable()->constrained('departments');
            $table->integer('qty_reject')->default(0);
            $table->string('type_reject')->nullable();
            $table->string('notes')->nullable();
            $table->foreignId('machine_id')->nullable()->constrained('machines');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traveler_movements');
    }
};
