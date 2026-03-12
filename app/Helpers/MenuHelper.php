<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class MenuHelper
{
    public static function menu()
    {
        $role = Auth::user()->role ?? '';

        switch ($role) {

            case 'super_admin':
                return [
                    ['name'=>'Dashboard','route'=>'dashboard','icon'=>'fas fa-tachometer-alt'],
                    [
                        'name'=>'User Management',
                        'icon'=>'fas fa-users',
                        'sub'=>[
                            ['name'=>'All Users','route'=>'superadmin.users'],
                            ['name'=>'Departments','route'=>'superadmin.departments'],
                        ]
                    ],
                    ['name'=>'Monitoring Produksi','route'=>'superadmin.monitoring','icon'=>'fas fa-industry'],
                ];

            case 'manager':
                return [
                    ['name'=>'Dashboard','route'=>'dashboard','icon'=>'fas fa-tachometer-alt'],
                    ['name'=>'Monitoring Produksi','route'=>'manager.monitoring','icon'=>'fas fa-industry'],
                    ['name'=>'Report','route'=>'manager.report','icon'=>'fas fa-chart-line'],
                ];

            case 'ppic':
                return [
                    ['name'=>'Dashboard','route'=>'dashboard','icon'=>'fas fa-tachometer-alt'],
                    ['name'=>'Monitoring Produksi','route'=>'ppic.monitoring','icon'=>'fas fa-industry'],
                    [
                        'name'=>'Master Management',
                        'icon'=>'fas fa-database',
                        'sub'=>[
                            ['name'=>'Customer','route'=>'ppic.customer'],
                            ['name'=>'Category Process','route'=>'ppic.category'],
                            ['name'=>'Style','route'=>'ppic.style'],
                            ['name'=>'Color','route'=>'ppic.color'],
                        ]
                    ],
                    ['name'=>'KK / PO Management','route'=>'ppic.kkpo','icon'=>'fas fa-file-alt'],
                ];

            case 'warehouse':
                return [
                    ['name'=>'Dashboard','route'=>'dashboard','icon'=>'fas fa-tachometer-alt'],
                    [
                        'name'=>'Traveler Management',
                        'icon'=>'fas fa-boxes',
                        'sub'=>[
                            ['name'=>'Pecah Traveler','route'=>'warehouse.pecah'],
                            ['name'=>'List Travelers','route'=>'warehouse.list'],
                        ]
                    ],
                ];

            case 'produksi':
                return [
                    ['name'=>'Dashboard','route'=>'dashboard','icon'=>'fas fa-tachometer-alt'],
                    [
                        'name'=>'Traveler Process',
                        'icon'=>'fas fa-sync',
                        'sub'=>[
                            ['name'=>'Data In','route'=>'produksi.datain'],
                            ['name'=>'Data Out','route'=>'produksi.dataout'],
                        ]
                    ],
                    ['name'=>'List Approve','route'=>'produksi.listapprove','icon'=>'fas fa-list'],
                    ['name'=>'List Problem','route'=>'produksi.listproblem','icon'=>'fas fa-exclamation-triangle'],
                    ['name'=>'Log Activity','route'=>'produksi.log','icon'=>'fas fa-clipboard-list'],
                ];

            default:
                return [
                    ['name'=>'Dashboard','route'=>'dashboard','icon'=>'fas fa-tachometer-alt'],
                ];
        }
    }
}