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
            //tambah kolom notes dengan tipe text nullable
            //tambah kolom payment_terms dengan tipe integer nullable setelah reject_allowance
            $table->integer('payment_terms')->nullable()->after('reject_allowance');
            $table->text('notes')->nullable()->after('payment_terms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkpo_managements', function (Blueprint $table) {
            //drop kolom notes & payment_terms         
            $table->dropColumn('notes');
            $table->dropColumn('payment_terms');
        });
    }
};
