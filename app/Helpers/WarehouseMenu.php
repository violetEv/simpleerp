<?php

namespace App\Helpers;

class WarehouseMenu
{
    public static function items()
    {
        return [
            ['name' => 'Dashboard', 'route' => 'warehouse.dashboard', 'icon' => 'fas fa-tachometer-alt'],
            ['name' => 'Order Management', 'route' => 'warehouse.order', 'icon' => 'fas fa-warehouse'], 
            [
                'name' => 'Traveler Management',
                'icon' => 'fas fa-boxes',
                'sub' => [
                    ['name' => 'Split Traveler', 'route' => 'warehouse.pecah'],
                    ['name' => 'List Travelers', 'route' => 'warehouse.list'],
                ]
            ],
        ];
    }
}

