<?php

namespace App\Helpers;

class ProduksiMenu
{
    public static function items()
    {
        return [
            ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-tachometer-alt'],
            [
                'name' => 'Traveler Process',
                'icon' => 'fas fa-sync',
                'sub' => [
                    ['name' => 'Data In', 'route' => 'produksi.datain'],
                    ['name' => 'Data Out', 'route' => 'produksi.dataout'],
                ]
            ],
            ['name' => 'List Approve', 'route' => 'produksi.listapprove', 'icon' => 'fas fa-list'],
            ['name' => 'List Problem', 'route' => 'produksi.listproblem', 'icon' => 'fas fa-exclamation-triangle'],
            ['name' => 'Log Activity', 'route' => 'produksi.log', 'icon' => 'fas fa-clipboard-list'],
        ];
    }
}
