<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KkpoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // buat detail dan header kkpo
        $kkpo = \App\Models\KkpoManagement::create([
            'no_kkpo' => 'KKPO-001',
            'customer_id' => 1,
            'currency_id' => 1,
            'date' => now(),
            // 'remark' => 'KKPO untuk customer A',
        ]);

        \App\Models\KkpoDetail::create([
            'kkpo_management_id' => $kkpo->id,
            'category_id' => 1,
            'style_id' => 1,
            'color_id' => 1,
            'item_id' => 1,
            'brand_id' => 1,
            'qty' => 100,
            'unit_id' => 1,
            'price' => 10000,
            // 'currency_id' => 1,
            'reject_allowance' => 5,
            'remark' => 'Detail KKPO untuk item A',
        ]);
    }
}