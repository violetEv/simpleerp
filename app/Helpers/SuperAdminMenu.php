<?php

namespace App\Helpers;

class SuperAdminMenu
{
    public static function items()
    {
        return [
            ['name' => 'Dasbor', 'route' => 'dashboard', 'icon' => 'fas fa-tachometer-alt'],
            // [
            //     'name' => 'Kelola Pengguna',
            //     'icon' => 'fas fa-users',
            //     'sub' => [
            ['name' => 'Pengguna', 'route' => 'superadmin.user', 'icon' => 'fas fa-users'],
            ['name' => 'Departemen', 'route' => 'superadmin.department', 'icon' => 'fas fa-building'],
            ['name' => 'Mesin', 'route' => 'superadmin.machine', 'icon' => 'fas fa-cogs'],

            //     ]
            // ],
            ['name' => 'Approval', 'route' => 'superadmin.approval', 'icon' => 'fas fa-check-circle'],
            ['name' => 'Monitoring', 'route' => 'superadmin.monitoring', 'icon' => 'fas fa-industry'],
            ['name' => 'Laporan', 'route' => 'superadmin.report', 'icon' => 'fas fa-chart-bar'],
            // ['name' => 'Log Aktivitas', 'route' => 'superadmin.activitylog', 'icon' => 'fas fa-clipboard-list'],
            // ['name' => 'Pengaturan', 'route' => 'superadmin.settings', 'icon' => 'fas fa-cogs'],
        ];
    }
}
