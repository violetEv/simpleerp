<?php

namespace Database\Seeders;

use App\Models\Style;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StylesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $styles = ['Style A', 'Style B', 'Style C', 'Style D', 'Style E'];

        foreach ($styles as $style) {
            Style::create(['name' => $style]);
        }
    }
}
