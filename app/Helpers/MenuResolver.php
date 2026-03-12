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
            'produksi'    => ProduksiMenu::items(),
            default       => [],
        };
    }
}