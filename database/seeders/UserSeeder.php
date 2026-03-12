<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'super_admin',
                'department_id' => null,
                'status' => 'active',
                
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'manager',
                'department_id' => null,
                'status' => 'active',
            ],
            [
                'name' => 'PPIC',
                'email' => 'ppic@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'ppic',
                'department_id' => null,
                'status' => 'active',
            ],
            [
                'name' => 'Admin Warehouse',
                'email' => 'adminwarehouse@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'warehouse',
                'department_id' => 33,
                'status' => 'active',
            ],
            [
                'name' => 'QC Before',
                'email' => 'qcbefore@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'produksi',
                'department_id' => 24,
                'status' => 'active',
            ],
            [
                'name' => 'Dryer',
                'email' => 'dryer@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'produksi',
                'department_id' => 25,
                'status' => 'active',
            ],
            [
                'name' => 'Send',
                'email' => 'send@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'produksi',
                'department_id' => 32,
                'status' => 'active',
            ]
        ];

        foreach ($userData as $user) {
            \App\Models\User::create($user);
        }
    }
}
