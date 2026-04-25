<?php

/**
 * Sidebar Menu Configuration
 * 
 * Structure:
 * - menu key untuk unique identifier
 * - label untuk display
 * - icon untuk visual
 * - route untuk navigation (opsional)
 * - href untuk custom link (opsional)
 * - roles untuk role-based access
 * - submenu untuk nested items (opsional)
 */

return [
    'menu' => [
        // ====== MAIN DASHBOARD ======
        [
            'menu' => 'dashboard',
            'label' => 'Dashboard',
            'icon' => 'fas fa-home',
            'route' => 'dashboard',
            'routeIsActive' => 'dashboard',
            'roles' => ['admin', 'marketing', 'kasir'],
        ],

        // ====== MASTER DATA ======
        [
            'label' => 'Master Data',
            'type' => 'header',
            'roles' => ['admin', 'marketing'],
        ],

        [
            'menu' => 'vouchers',
            'label' => 'Voucher',
            'icon' => 'fas fa-box',
            'route' => 'vouchers.index',
            'routeIsActive' => 'vouchers',
            'roles' => ['admin', 'marketing'],
        ],

        [
            'menu' => 'user-group',
            'label' => 'Users',
            'icon' => 'fas fa-user-shield',
            'roles' => ['admin'],
            'submenu' => [
                 [
                    'menu' => 'sales-master',
                    'label' => 'Sales',
                    'icon' => 'fa-solid fa-people-roof',
                    'href' => 'sales/index.html',
                    'roles' => ['admin'],
                ],
                [
                    'menu' => 'users',
                    'label' => 'Pengguna',
                    'icon' => 'fas fa-user',
                    'route' => 'users.index',
                    'roles' => ['admin'],
                ],
                [
                    'menu' => 'customers',
                    'label' => 'Pelanggan',
                    'icon' => 'fas fa-users',
                    'route' => 'members.index',
                    'routeIsActive' => 'members',
                    'roles' => ['admin', 'pemasaran'],
                ],
            ],
        ],

        [
            'menu' => 'data-keuangan',
            'label' => 'Data Keuangan',
            'icon' => 'fa-regular fa-credit-card',
            'roles' => ['admin'],
            'submenu' => [
                 [
                    'menu' => 'coa-type',
                    'label' => 'Tipe COA',
                    'icon' => 'fa-solid fa-align-right',
                    'route' => 'coa_types.index',
                    'routeIsActive' => 'coa_types',
                    'roles' => ['admin'],
                ],
                [
                    'menu' => 'coa',
                    'label' => 'COA',
                    'icon' => 'fa-solid fa-align-right',
                    'route' => 'coas.index',
                    'routeIsActive' => 'coas',
                    'roles' => ['admin'],
                ],
                [
                    'menu' => 'bank',
                    'label' => 'Bank',
                    'icon' => 'fa-solid fa-building-columns',
                    'route' => 'banks.index',
                    'routeIsActive' => 'banks',
                    'roles' => ['admin'],
                ],
            ],
        ],

        // ====== PENGATURAN ======
        [
            'label' => 'Pengaturan',
            'type' => 'header',
            'roles' => ['admin'],
        ],

        [
            'menu' => 'app-profile',
            'label' => 'App Profile',
            'icon' => 'fa-solid fa-cogs',
            'href' => '#',
            'roles' => ['admin'],
        ],

        [
            'menu' => 'roles-permissions',
            'label' => 'Role & Permission',
            'icon' => 'fas fa-user-shield',
            'roles' => ['admin'],
            'submenu' => [
                [
                    'menu' => 'roles',
                    'label' => 'All Roles',
                    'route' => 'roles.index',
                    'icon' => 'fas fa-circle',
                    'icon_size' => '0.4rem',
                ],
                [
                    'menu' => 'add-role',
                    'label' => 'Add Role',
                    'href' => '#',
                    'icon' => 'fas fa-circle',
                    'icon_size' => '0.4rem',
                ],
                [
                    'menu' => 'permissions',
                    'label' => 'Permissions',
                    'href' => '#',
                    'icon' => 'fas fa-circle',
                    'icon_size' => '0.4rem',
                ],
            ],
        ],
    ],
];
