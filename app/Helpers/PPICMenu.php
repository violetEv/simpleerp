<?php

namespace App\Helpers;

class PPICMenu
{
    public static function items()
    {
        return [
            ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-tachometer-alt'],
            [
                'name' => 'Master Data',
                'icon' => 'fas fa-database',
                'sub' => [
                    ['name' => 'Customer', 'route' => 'ppic.customer'],
                    ['name' => 'Category Process', 'route' => 'ppic.category'],
                    ['name' => 'Style', 'route' => 'ppic.style'],
                    ['name' => 'Color', 'route' => 'ppic.color'],
                    ['name' => 'Item', 'route' => 'ppic.item'],
                    ['name' => 'Brand', 'route' => 'ppic.brand'],
                    ['name' => 'Unit', 'route' => 'ppic.unit'],
                    ['name' => 'Currency', 'route' => 'ppic.currency'],
                    // ['name' => 'KKPO', 'route' => 'ppic.kkpo']
                ]
            ],
            ['name' => 'KK / PO', 'route' => 'ppic.kkpo', 'icon' => 'fas fa-file-alt'],
            ['name' => 'Monitoring', 'route' => 'ppic.monitoring', 'icon' => 'fas fa-industry'],
            ['name' => 'Report','route' => 'ppic.report', 'icon' => 'fas fa-chart-bar']
        ];
    }
}
