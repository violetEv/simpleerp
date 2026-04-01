<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryProcess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Category A', 'Category B', 'Category C', 'Category D', 'Category E'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
