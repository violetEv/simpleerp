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
        //rename table kkpo_style to kkpo_management_style
        Schema::rename('kkpo_style', 'kkpo_management_style');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //rename table kkpo_management_style back to kkpo_style
        Schema::rename('kkpo_management_style', 'kkpo_style');
    }
};
