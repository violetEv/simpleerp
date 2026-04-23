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
            // tambahkan kolom customer_id set null setelah no_kkpo. diambil dari tabel customers. foreignkey
            $table->unsignedBigInteger('customer_id')->nullable()->after('no_kkpo');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkpo_managements', function (Blueprint $table) {
            // hapus kolom customer_id
            $table->dropForeign(['customer_id']);

            $table->dropColumn('customer_id');

        });
    }
};
