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
        //rename table kkpo_category to kkpo_management_category
        Schema::rename('kkpo_category', 'kkpo_management_category');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //rename table kkpo_management_category back to kkpo_category
        Schema::rename('kkpo_management_category', 'kkpo_category');
    }
};
