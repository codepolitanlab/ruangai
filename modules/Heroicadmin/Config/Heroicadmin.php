<?php

namespace Heroicadmin\Config;

use CodeIgniter\Config\BaseConfig;

class Heroicadmin extends BaseConfig
{
    public $title        = 'Jagoansiber';
    public $urlScope     = 'admin';
    public $rootPanelUrl = 'dashboard';
    public $sidebarMenu  = [
        10 => [
            'label'  => 'Dashboard',
            'icon'   => 'bi bi-grid-fill',
            'module' => 'dashboard',
            'url'    => '',
        ],
        20 => [
            'label'    => 'User Management',
            'icon'     => 'bi bi-lock-fill',
            'url'      => '#',
            'module'   => 'user',
            'children' => [
                'list' => [
                    'label'     => 'Users',
                    'icon'      => 'bi bi-people',
                    'url'       => 'user',
                    'submodule' => 'user',
                ],
                'role' => [
                    'label'     => 'Roles',
                    'icon'      => 'bi bi-person-gear',
                    'url'       => 'user/role',
                    'submodule' => 'role',
                ],
            ],
        ],
        30 => [
            'label'    => 'E-Learning',
            'icon'     => 'bi bi-book-fill',
            'url'      => '#',
            'module'   => 'elearning',
            'children' => [
                'online_class' => [
                    'label'     => 'Online Classes',
                    'icon'      => 'bi bi-laptop',
                    'url'       => 'course',
                    'submodule' => 'course',
                ],
            ],
        ],
        50 => [
            'label'    => 'Products',
            'icon'     => 'bi bi-bag-fill',
            'url'      => '#',
            'module'   => 'product',
            'children' => [
                'course' => [
                    'label'     => 'Course',
                    'icon'      => 'bi bi-book',
                    'url'       => '/zpanel/products/course',
                    'submodule' => 'course',
                ],
            ],
        ],
        60 => [
            'label'    => 'Vouchers',
            'icon'     => 'bi bi-bag-fill',
            'url'      => '#',
            'module'   => 'voucher',
            'children' => [
                'sales' => [
                    'label'     => 'Penjualan Voucher',
                    'icon'      => 'bi bi-tag-fill',
                    'url'       => '/zpanel/vouchers/sales',
                    'submodule' => 'sales',
                ],
            ],
        ],
        40 => [
            'label'    => 'Configuration',
            'icon'     => 'bi bi-house-gear-fill',
            'url'      => '#',
            'module'   => 'config',
            'children' => [
                'course' => [
                    'label'     => 'Settings',
                    'icon'      => 'bi bi-sliders',
                    'url'       => 'setting',
                    'submodule' => 'setting',
                ],
            ],
        ],
    ];
}
