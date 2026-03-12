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
        Schema::table('travelers', function (Blueprint $table) {

            $table->integer('qty')->after('no_traveler');

            $table->foreignId('dept_asal_id')
                ->nullable()
                ->after('surat_jalan_id')
                ->constrained('departments')
                ->nullOnDelete();

            $table->foreignId('dept_tujuan_id')
                ->nullable()
                ->after('dept_asal_id')
                ->constrained('departments')
                ->nullOnDelete();

            $table->date('tanggal')->nullable()->after('status');

            $table->text('notes')->nullable()->after('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('travelers', function (Blueprint $table) {

            $table->dropColumn('qty');
            $table->dropForeign(['dept_asal_id']);
            $table->dropForeign(['dept_tujuan_id']);
            $table->dropColumn(['dept_asal_id', 'dept_tujuan_id', 'tanggal', 'notes']);
        });
    }
};
