<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'SIMPONDOK',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>SIM</b>PONDOK',

    'logo_mini' => '<b>S</b>P',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'green',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'MAIN NAVIGATION',
        [
            'text'        => 'Dasboard',
            'url'         => 'admin',
            'icon'        => 'dashboard',
        ],
        
        [
            'text'    => 'Hak Akses',
            'icon'    => 'share',
            'permission' => [
                'permission.permission.index',
                'permission.role.index',
                'permission.group.index',
            ],
            'submenu' => [
                [
                    'text'        => 'Permission',
                    'url'         => 'admin/permission',
                    'icon'        => 'user',
                    'permission'  => 'permission.permission.index',
                ],
                [
                    'text'        => 'Groups',
                    'url'         => 'admin/group',
                    'icon'        => 'user',
                    'permission'  => 'permission.group.index',
                ],
                [
                    'text'        => 'Roles',
                    'url'         => 'admin/role',
                    'icon'        => 'user',
                    'permission'  => 'permission.role.index',
                ],
            ],
        ],
        [
            'text'    => 'Master',
            'icon'    => 'share',
            'permission' => [
                'permission.mapel.index',
                'permission.tingkat.index',
                'permission.kelas.index'
            ],
            'submenu' => [
                [
                    'text' => 'Tahun Ajaran',
                    'url'  => 'admin/tahun_ajaran',
                    'permission'  => 'permission.tahun_ajaran.index',
                ],
                [
                    'text' => 'Mata Pelajaran',
                    'url'  => 'admin/mapel',
                    'permission'  => 'permission.mapel.index',
                ],
                
                [
                    'text' => 'Tingkat',
                    'url'  => 'admin/tingkat',
                    'permission'  => 'permission.tingkat.index',
                ],
                [
                    'text' => 'Sarpras',
                    'url'  => 'admin/sarpras',
                    'permission'  => 'permission.sarpras.index',
                ],
            ],
        ],
        [
            'text'        => 'Users',
            'url'         => 'admin/user',
            'icon'        => 'user',
//            'label'       => 4,
//            'label_color' => 'success',
            'permission'  => 'permission.user.index',
        ],
        [
            'text'        => 'Siswa',
            'url'         => 'admin/siswa',
            'icon'        => 'user',
        ],
        
        [
            'text'    => 'Default',
            'icon'    => 'share',
            'permission' => [
                'permission.mrombel.index',
                'permission.m_tingkat_mapel.index'
            ],
            'submenu' => [
                [
                    'text'        => 'Rombel',
                    'url'         => 'admin/mrombel',
                    'icon'        => 'user',
                    'permission'  => 'permission.mrombel.index',
                ],
                [
                    'text'        => 'Tingkat Mapel',
                    'url'         => 'admin/m_tingkat_mapel',
                    'icon'        => 'user',
                    'permission'  => 'permission.m_tingkat_mapel.index',
                ],
            ],
        ],
        [
            'text'    => 'Pengaturan Rombel',
            'icon'    => 'share',
            'permission' => [
                'permission.rombel.index',
                'permission.rombel_siswa.index',
                'permission.tingkat_mapel.index',
                'permission.siswa_nilai.index',
            ],
            'submenu' => [
                [
                    'text'        => 'Rombel',
                    'url'         => 'admin/rombel',
                    'icon'        => 'user',
                    'permission'  => 'permission.rombel.index',
                ],
                [
                    'text'        => 'Rombel Siwa',
                    'url'         => 'admin/rombel_siswa',
                    'icon'        => 'user',
                    'permission'  => 'permission.rombel_siswa.index',
                ],
                [
                    'text'        => 'Tingkat Mapel',
                    'url'         => 'admin/tingkat_mapel',
                    'icon'        => 'user',
                    'permission'  => 'permission.tingkat_mapel.index',
                ],
                [
                    'text'        => 'Siswa Nilai',
                    'url'         => 'admin/siswa_nilai',
                    'icon'        => 'user',
                    'permission'  => 'permission.siswa_nilai.index',
                ],
            ],
        ],
//        'ACCOUNT SETTINGS',
//        [
//            'text' => 'Profile',
//            'url'  => 'admin/settings',
//            'icon' => 'user',
//        ],
//        [
//            'text' => 'Change Password',
//            'url'  => 'admin/settings',
//            'icon' => 'lock',
//        ],
//        [
//            'text'    => 'Multilevel',
//            'icon'    => 'share',
//            'submenu' => [
//                [
//                    'text' => 'Level One',
//                    'url'  => '#',
//                ],
//                [
//                    'text'    => 'Level One',
//                    'url'     => '#',
//                    'submenu' => [
//                        [
//                            'text' => 'Level Two',
//                            'url'  => '#',
//                        ],
//                        [
//                            'text'    => 'Level Two',
//                            'url'     => '#',
//                            'submenu' => [
//                                [
//                                    'text' => 'Level Three',
//                                    'url'  => '#',
//                                ],
//                                [
//                                    'text' => 'Level Three',
//                                    'url'  => '#',
//                                ],
//                            ],
//                        ],
//                    ],
//                ],
//                [
//                    'text' => 'Level One',
//                    'url'  => '#',
//                ],
//            ],
//        ],
//        'LABELS',
//        [
//            'text'       => 'Important',
//            'icon_color' => 'red',
//        ],
//        [
//            'text'       => 'Warning',
//            'icon_color' => 'yellow',
//        ],
//        [
//            'text'       => 'Information',
//            'icon_color' => 'aqua',
//        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        App\Lib\MyMenuFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
//        'datatables' => true,
//        'select2'    => true,
    ],
];
