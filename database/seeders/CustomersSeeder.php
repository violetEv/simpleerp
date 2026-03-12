<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = ['Customer A', 'Customer B', 'Customer C', 'Customer D', 'Customer E'];

        foreach ($customers as $customer) {
            Customer::create(['name' => $customer]);
        }
    }
}
