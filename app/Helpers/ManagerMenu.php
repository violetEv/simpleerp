<?php

namespace App\Helpers;

class ManagerMenu
{
    public static function items()
    {
        return [
            ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-tachometer-alt'],
            ['name' => 'Monitoring Produksi', 'route' => 'manager.monitoring', 'icon' => 'fas fa-industry'],
            ['name' => 'Report', 'route' => 'manager.report', 'icon' => 'fas fa-chart-line'],
        ];
    }
}
