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
        //rename table kkpo_brand to kkpo_management_brand
        Schema::rename('kkpo_brand', 'kkpo_management_brand');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //rename table kkpo_management_brand back to kkpo_brand
        Schema::rename('kkpo_management_brand', 'kkpo_brand');
    }
};
