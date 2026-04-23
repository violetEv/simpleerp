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
        Schema::table('traveler_movements', function (Blueprint $table) {

            // cek dulu kolom lama masih ada atau tidak
            if (Schema::hasColumn('traveler_movements', 'dept_id')) {

                $table->dropForeign(['dept_id']);
                $table->renameColumn('dept_id', 'current_dept_id');

                $table->foreign('current_dept_id')
                    ->references('id')
                    ->on('departments')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traveler_movements', function (Blueprint $table) {

            if (Schema::hasColumn('traveler_movements', 'current_dept_id')) {

                $table->dropForeign(['current_dept_id']);
                $table->renameColumn('current_dept_id', 'dept_id');

                $table->foreign('dept_id')
                    ->references('id')
                    ->on('departments')
                    ->onDelete('cascade');
            }
        });
    }
};
