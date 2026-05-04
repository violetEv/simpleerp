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
        Schema::create('kkpo_details', function (Blueprint $table) {
            $table->id();

            // relasi ke header
            $table->foreignId('kkpo_management_id')->constrained()->cascadeOnDelete();

            // relasi master (SEMUA nullable biar fleksibel)
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('style_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('item_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();

            // data utama per baris
            $table->decimal('qty', 12, 2)->default(0);
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();

            // harga per baris (lebih fleksibel daripada di header)
            $table->decimal('price', 15, 2)->nullable();

            // optional (kalau nanti butuh)
            $table->text('remark')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kkpo_details');
    }
};
