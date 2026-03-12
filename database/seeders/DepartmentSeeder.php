<?php

namespace Database\Seeders;

use App\Models\Departments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'QC Before', 'slug' => 'qc-before'],
            ['name' => 'Dryer', 'slug' => 'dryer'],
            ['name' => 'Washing', 'slug' => 'washing'],
            ['name' => 'Dyeing', 'slug' => 'dyeing'],
            ['name' => 'Manual Process', 'slug' => 'manual-process'],
            ['name' => 'QC After', 'slug' => 'qc-after'],
            ['name' => 'Folding', 'slug' => 'folding'],
            ['name' => 'Packing', 'slug' => 'packing'],
            ['name' => 'Send', 'slug' => 'send'],
            ['name' => 'Warehouse', 'slug' => 'warehouse']
        ];

        foreach ($departments as $dept) {
            Departments::create($dept);
        }

    }
}
