<?php

namespace App\Helpers;

class SuperAdminMenu
{
    public static function items()
    {
        return [
            ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-tachometer-alt'],
            // [
            //     'name' => 'Kelola Pengguna',
            //     'icon' => 'fas fa-users',
            //     'sub' => [
            ['name' => 'User', 'route' => 'superadmin.user', 'icon' => 'fas fa-users'],
            ['name' => 'Department', 'route' => 'superadmin.department', 'icon' => 'fas fa-building'],
            ['name' => 'Permission', 'route' => 'superadmin.permission', 'icon' => 'fas fa-check-circle'],
            ['name' => 'Machine', 'route' => 'superadmin.machine', 'icon' => 'fas fa-cogs'],

            //     ]
            // ],
            ['name' => 'Monitoring', 'route' => 'superadmin.monitoring', 'icon' => 'fas fa-industry'],
            ['name' => 'Report', 'route' => 'superadmin.report', 'icon' => 'fas fa-chart-bar'],
            // ['name' => 'Activity Log', 'route' => 'superadmin.activitylog', 'icon' => 'fas fa-clipboard-list'],
            // ['name' => 'Settings', 'route' => 'superadmin.settings', 'icon' => 'fas fa-cogs'],
        ];
    }
}
