<?php

namespace Heroicadmin\Config;

use CodeIgniter\Config\BaseConfig;

class Heroicadmin extends BaseConfig
{
    public $title        = 'RuangAI';
    public $urlScope     = 'ruangpanel';
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
                'token' => [
                    'label'     => 'Reward Token',
                    'icon'      => 'bi bi-tag-fill',
                    'url'       => 'user/token',
                    'submodule' => 'token',
                ],
            ],
        ],
        25 => [
            'label'    => 'Scholarship',
            'icon'     => 'bi bi-lock-fill',
            'url'      => '#',
            'module'   => 'scholarship',
            'children' => [
                'scholarship' => [
                    'label'     => 'Events',
                    'icon'      => 'bi bi-people',
                    'url'       => 'scholarship/events',
                    'submodule' => 'event',
                ],
                'participants' => [
                    'label'     => 'Participants',
                    'icon'      => 'bi bi-people',
                    'url'       => 'scholarship/participants',
                    'submodule' => 'participants',
                ],
                'referral' => [
                    'label'     => 'Referral',
                    'icon'      => 'bi bi-person-gear',
                    'url'       => 'scholarship/referral',
                    'submodule' => 'referral',
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
                    'url'       => 'course/product',
                    'submodule' => 'course_product',
                ],
            ],
        ],
        // 60 => [
        //     'label'    => 'Vouchers',
        //     'icon'     => 'bi bi-bag-fill',
        //     'url'      => '#',
        //     'module'   => 'voucher',
        //     'children' => [
        //         'sales' => [
        //             'label'     => 'Penjualan Voucher',
        //             'icon'      => 'bi bi-tag-fill',
        //             'url'       => '/zpanel/vouchers/sales',
        //             'submodule' => 'sales',
        //         ],
        //     ],
        // ],
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
