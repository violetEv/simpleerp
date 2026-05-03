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
        //rename table kkpo_item to kkpo_management_item
        Schema::rename('kkpo_item', 'kkpo_management_item');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //rename table kkpo_management_item back to kkpo_item
        Schema::rename('kkpo_management_item', 'kkpo_item');
    }
};
