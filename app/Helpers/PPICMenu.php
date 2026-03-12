<?php

namespace App\Helpers;

class PPICMenu
{
    public static function items()
    {
        return [
            ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-tachometer-alt'],
            [
                'name' => 'Master Management',
                'icon' => 'fas fa-database',
                'sub' => [
                    ['name' => 'Customer', 'route' => 'ppic.customer'],
                    ['name' => 'Category Process', 'route' => 'ppic.category'],
                    ['name' => 'Style', 'route' => 'ppic.style'],
                    ['name' => 'Color', 'route' => 'ppic.color'],
                ]
            ],
            ['name' => 'KK / PO Management', 'route' => 'ppic.kkpo', 'icon' => 'fas fa-file-alt'],
            ['name' => 'Monitoring Produksi', 'route' => 'ppic.monitoring', 'icon' => 'fas fa-industry']
        ];
    }
}
