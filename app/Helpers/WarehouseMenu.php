<?php

namespace App\Helpers;

class WarehouseMenu
{
    public static function items()
    {
        return [
            ['name' => 'Dasbor', 'route' => 'warehouse.dashboard', 'icon' => 'fas fa-tachometer-alt'],
            ['name' => 'Surat Jalan IN', 'route' => 'warehouse.suratjalan', 'icon' => 'fas fa-warehouse'], 
            [
                'name' => 'Traveler',
                'icon' => 'fas fa-boxes',
                'sub' => [
                    ['name' => 'Buat Traveler', 'route' => 'warehouse.pecah'],
                    ['name' => 'Daftar Traveler Baru', 'route' => 'warehouse.list-new'],
                    ['name' => 'Daftar Traveler Rework', 'route' => 'warehouse.list-rework']
                ]
            ],
            ['name' => 'Log Warehouse', 'route' => 'warehouse.log-warehouse', 'icon' => 'fas fa-history'],
        ];
    }
}

