<?php

namespace App\Helpers;

class WarehouseMenu
{
    public static function items()
    {
        return [
            ['name' => 'Dashboard', 'route' => 'warehouse.dashboard', 'icon' => 'fas fa-tachometer-alt'],
            ['name' => 'Surat Jalan IN', 'route' => 'warehouse.suratjalan', 'icon' => 'fas fa-warehouse'], 
            [
                'name' => 'Traveler',
                'icon' => 'fas fa-boxes',
                'sub' => [
                    ['name' => 'Split Traveler', 'route' => 'warehouse.pecah'],
                    ['name' => 'List Travelers', 'route' => 'warehouse.list'],
                ]
            ],
        ];
    }
}

