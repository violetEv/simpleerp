<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = ['Red', 'Green', 'Blue', 'Yellow', 'Black'];

        foreach ($colors as $color) {
            Color::create(['name' => $color]);
        }
    }
}
