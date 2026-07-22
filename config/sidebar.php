<?php

return [
    [
        'title' => 'Dashboard',
        'icon' => 'fas-house',
        'route' => 'dashboard',
        'active' => 'dashboard*',
        'permission' => null, // Bebas diakses semua user terautentikasi
    ],
    [
        'title' => 'Pengelolaan User',
        'icon' => 'fas-users',
        'active' => ['users*', 'roles*', 'permissions*'],
        'permission' => ['view-users', 'view-roles', 'view-permissions'], // Parent muncul jika punya salah satu
        'children' => [
            [
                'title' => 'Users',
                'icon' => 'fas-user',
                'route' => 'users.index',
                'active' => 'users*',
                'permission' => 'view-users',
            ],
            [
                'title' => 'Roles',
                'icon' => 'fas-shield',
                'route' => 'roles.index',
                'active' => 'roles*',
                'permission' => 'view-roles',
            ],
            [
                'title' => 'Permissions',
                'icon' => 'fas-key',
                'route' => 'permissions.index',
                'active' => 'permissions*',
                'permission' => 'view-permissions',
            ],
        ],
    ],
    [
        'title' => 'Pengelolaan Toko',
        'icon' => 'fas-store',
        'route' => 'tokos.index',
        'active' => 'tokos*',
        'permission' => 'view-tokos',
    ],
    [
        'title' => 'Kasir',
        'icon' => 'fas-cash-register',
        'route' => 'kasir.dashboard',
        'active' => 'kasir*',
        'permission' => 'kasir',
    ],
    [
        'title' => 'Pengelolaan Penjualan',
        'icon' => 'fas-chart-line',
        'route' => 'penjualans.index',
        'active' => 'penjualans*',
        'permission' => 'view-penjualans',
    ],
    [
        'title' => 'Pengelolaan Produk',
        'icon' => 'fas-boxes-stacked',
        'active' => ['produks*', 'kategories*', 'satuans*'],
        'permission' => ['view-produks', 'view-kategories', 'view-satuans'],
        'children' => [
            [
                'title' => 'Produk',
                'icon' => 'fas-box',
                'route' => 'produks.index',
                'active' => 'produks*',
                'permission' => 'view-produks',
            ],
            [
                'title' => 'Kategori',
                'icon' => 'fas-tags',
                'route' => 'kategories.index',
                'active' => 'kategories*',
                'permission' => 'view-kategories',
            ],
            [
                'title' => 'Satuan',
                'icon' => 'fas-scale-balanced',
                'route' => 'satuans.index',
                'active' => 'satuans*',
                'permission' => 'view-satuans',
            ],
        ],
    ],
    [
        'title' => 'Stok',
        'icon' => 'fas-boxes-packing',
        'route' => 'stoks.index',
        'active' => 'stoks*',
        'permission' => 'view-stoks',
    ],
    [
        'title' => 'Laporan',
        'icon' => 'fas-chart-line',
        'route' => 'laporans.penjualan',
        'active' => 'laporans*',
        'permission' => 'view-laporanpenjualans',
    ],
    [
        'title' => 'Docs',
        'icon' => 'fas-book',
        'active' => ['docs*'],
        'permission' => null,
        'children' => [
            [
                'title' => 'Instalasi Printer',
                'icon' => 'fas-print',
                'route' => 'docs.printer', 
                'active' => 'docs/printer*',
                'permission' => null
            ],
        ],
    ],
    
];