<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class MenuResolver
{
    public static function get()
    {
        $role = Auth::user()->role ?? '';

        return match ($role) {
            'super_admin' => SuperAdminMenu::items(),
            'manager'     => ManagerMenu::items(),
            'ppic'        => PpicMenu::items(),
            'warehouse'   => WarehouseMenu::items(),
            'produksi'    => self::produksiMenuWithCondition(Auth::user()),
            default       => [],
        };
    }
    private static function produksiMenuWithCondition($user)
    {
        $menu = ProduksiMenu::items();

        if ($user->department && $user->department->name === 'Warehouse Send') {
            array_splice($menu, 2, 0, [[
                'name' => 'Surat Jalan Out',
                'route' => 'produksi.suratjalanout.index',
                'icon' => 'fas fa-truck'
            ]]);
        }

        return $menu;
    }
}
