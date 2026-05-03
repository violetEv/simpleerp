<?php

namespace App\Helpers;

class BreadcrumbResolver
{
    public static function fromMenu($menus)
    {
        $currentRoute = request()->route()?->getName();

        if (!$currentRoute) return [];

        foreach ($menus as $menu) {

            /**
             *  1. CEK SUBMENU DULU
             */
            if (isset($menu['sub'])) {
                foreach ($menu['sub'] as $sub) {

                    if (self::isMatch($currentRoute, $sub['route'])) {

                        $breadcrumbs = [];

                        // parent
                        $breadcrumbs[] = [
                            'label' => $menu['name'],
                            'url' => '#'
                        ];

                        // child
                        $breadcrumbs[] = [
                            'label' => $sub['name'],
                            'url' => route($sub['route'])
                        ];

                        self::appendChild($breadcrumbs, $currentRoute);

                        return $breadcrumbs;
                    }
                }
            }

            /**
             *  2. MENU TANPA SUB
             */
            if (isset($menu['route'])) {

                if (self::isMatch($currentRoute, $menu['route'])) {

                    $breadcrumbs = [];

                    $breadcrumbs[] = [
                        'label' => $menu['name'],
                        'url' => route($menu['route'])
                    ];

                    self::appendChild($breadcrumbs, $currentRoute);

                    return $breadcrumbs;
                }
            }
        }

        return [];
    }

    /**
     *  FIX MATCH (INI KUNCI UTAMA)
     */
    private static function isMatch($current, $base)
    {
        return $current === $base || str_starts_with($current, $base . '.');
    }

    /**
     * 🔥 HANDLE DETAIL / CREATE / EDIT
     */
    private static function appendChild(&$breadcrumbs, $route)
    {
        if (str_ends_with($route, '.show')) {
            $breadcrumbs[] = ['label' => 'Detail', 'url' => '#'];
        }

        if (str_ends_with($route, '.store') || str_ends_with($route, '.create')) {
            $breadcrumbs[] = ['label' => 'Create', 'url' => '#'];
        }

        if (str_ends_with($route, '.edit')) {
            $breadcrumbs[] = ['label' => 'Edit', 'url' => '#'];
        }
    }
//         $id = request()->route('id'); // ambil param {id}

//     if (str_ends_with($route, '.show')) {
//         $breadcrumbs[] = [
//             'label' => $id ? "Detail #$id" : 'Detail',
//             'url' => '#'
//         ];
//     }

//     if (str_ends_with($route, '.create')) {
//         $breadcrumbs[] = ['label' => 'Create', 'url' => '#'];
//     }

//     if (str_ends_with($route, '.edit')) {
//         $breadcrumbs[] = [
//             'label' => $id ? "Edit #$id" : 'Edit',
//             'url' => '#'
//         ];
//     }
// }
}