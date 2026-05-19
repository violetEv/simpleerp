<?php

namespace App\Helpers;

class ManagerMenu
{
    public static function items()
    {
        return [
            ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-tachometer-alt'],
            ['name' => 'Approval', 'route' => 'manager.approval', 'icon' => 'fas fa-check-circle'],
            ['name' => 'Monitoring', 'route' => 'manager.monitoring', 'icon' => 'fas fa-industry'],
            ['name' => 'Report', 'route' => 'manager.report', 'icon' => 'fas fa-chart-bar']
            // 'sub' => [
                    // ['name' => 'Daily Report', 'route' => 'manager.report.daily', 'icon' => 'fas fa-calendar-day'],
                    // ['name' => 'Monthly Report', 'route' => 'manager.report.monthly', 'icon' => 'fas fa-calendar-alt'],
                    // ['name' => 'Report By Style', 'route' => 'manager.report.daily', 'icon' => 'fas fa-calendar-day'],
                    // ['name' => 'Report By Customer', 'route' => 'manager.report.monthly', 'icon' => 'fas fa-calendar-alt'],
            // ]],
        ];
    }
}
