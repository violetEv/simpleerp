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
        Schema::table('kkpo_managements', function (Blueprint $table) {
            $table->dropForeign('kkpos_customer_id_foreign'); // <- pakai ini
            $table->dropColumn('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkpo_managements', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable()->after('kkpo_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
        });
    }
};
