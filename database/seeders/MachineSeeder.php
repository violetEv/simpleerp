<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $machines = [
            ['name' => 'Machine 1', 'department_id' => 1],
            ['name' => 'Machine 2', 'department_id' => 1],
            ['name' => 'Machine 3', 'department_id' => 2],
            ['name' => 'Machine 4', 'department_id' => 2],
            ['name' => 'Machine 5', 'department_id' => 3],
        ];

        foreach ($machines as $machine) {
            \App\Models\Machine::create($machine);
        }
    }
}
