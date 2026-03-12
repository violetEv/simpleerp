<?php

namespace App\Helpers;

class SuperAdminMenu
{
    public static function items()
    {
        return [
            ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-tachometer-alt'],
            [
                'name' => 'User Management',
                'icon' => 'fas fa-users',
                'sub' => [
                    ['name' => 'All Users', 'route' => 'superadmin.users'],
                    ['name' => 'Departments', 'route' => 'superadmin.departments'],
                ]
            ],
            ['name' => 'Monitoring Produksi', 'route' => 'superadmin.monitoring', 'icon' => 'fas fa-industry'],
        ];
    }
}
