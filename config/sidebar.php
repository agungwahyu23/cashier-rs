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
            'menu' => 'insurances',
            'label' => 'Data Asuransi',
            'icon' => 'fa-solid fa-shield-heart',
            'route' => 'insurances.index',
            'routeIsActive' => 'insurances',
            'roles' => ['admin', 'marketing'],
        ],
        [
            'menu' => 'procedures',
            'label' => 'Data Tindakan Medis',
            'icon' => 'fa-solid fa-briefcase-medical',
            'route' => 'procedures.index',
            'routeIsActive' => 'procedures',
            'roles' => ['admin', 'marketing'],
        ],
        [
            'menu' => 'vouchers',
            'label' => 'Data Voucher',
            'icon' => 'fa-solid fa-ticket',
            'route' => 'vouchers.index',
            'routeIsActive' => 'vouchers',
            'roles' => ['admin', 'marketing'],
        ],

        // ====== TRANSAKSI ======
        [
            'label' => 'Transaksi',
            'type' => 'header',
            'roles' => ['admin', 'kasir'],
        ],
        [
            'menu' => 'transactions',
            'label' => 'Transaksi',
            'icon' => 'fa-solid fa-cash-register',
            'route' => 'transactions.index',
            'routeIsActive' => 'transactions',
            'roles' => ['admin', 'kasir'],
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
                    // 'route' => 'roles.index',
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
