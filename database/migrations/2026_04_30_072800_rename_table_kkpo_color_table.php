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
        //rename table kkpo_color to kkpo_management_color
        Schema::rename('kkpo_color', 'kkpo_management_color');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('kkpo_management_color', 'kkpo_color');
    }
};
