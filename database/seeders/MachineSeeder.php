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
        // Machine untuk dyeing dan washing
        $machines = [
            ['name' => 'Dyeing Machine 1', 'department_id' => 27],
            ['name' => 'Dyeing Machine 2', 'department_id' => 27],
            ['name' => 'Washing Machine 1', 'department_id' => 26],
            ['name' => 'Washing Machine 2', 'department_id' => 26],
        ];

        foreach ($machines as $machine) {
            \App\Models\Machine::create($machine);
        }
    }
}
