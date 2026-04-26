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
                    ['name' => 'Daftar Traveler', 'route' => 'warehouse.list'],
                ]
            ],
        ];
    }
}

