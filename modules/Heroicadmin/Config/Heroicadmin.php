<?php

namespace Heroicadmin\Config;

use CodeIgniter\Config\BaseConfig;

class Heroicadmin extends BaseConfig
{
    public $title        = 'RuangAI';
    public $urlScope     = 'ruangpanel';
    public $rootPanelUrl = 'dashboard';
    public $sidebarMenu  = [
        [
            'label'  => 'Dashboard',
            'icon'   => 'bi bi-grid-fill',
            'module' => 'dashboard',
            'url'    => '',
        ],
        [
            'label'  => 'Shortener',
            'icon'   => 'bi bi-link',
            'module' => 'shortener',
            'url'    => 'shortener',
        ],
        [
            'label' => 'Challenge',
            'icon' => 'bi bi-trophy',
            'module' => 'challenge',
            'url' => 'challenge/submissions'
        ],
        [
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
        [
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
                'followup_comentors' => [
                    'label'     => 'Followup Comentor',
                    'icon'      => 'bi bi-chat-dots',
                    'url'       => 'scholarship/followup-comentors',
                    'submodule' => 'followup_comentors',
                ],
                'referral' => [
                    'label'     => 'Referral',
                    'icon'      => 'bi bi-person-gear',
                    'url'       => 'scholarship/referral',
                    'submodule' => 'referral',
                ],
            ],
        ],
        [
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
        [
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
        // [
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
        [
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
        [
            'label'    => 'Development',
            'icon'     => 'bi bi-hammer',
            'url'      => '#',
            'module'   => 'development',
            'children' => [
                'logviewer' => [
                    'label'     => 'Log Viewer',
                    'icon'      => 'bi bi-file-earmark-text',
                    'url'       => 'logviewer',
                    'submodule' => 'logviewer',
                ],
            ],
        ],
        [
            'label'    => 'Referral',
            'icon'     => 'bi bi-tag',
            'url'      => '#',
            'module'   => 'referral',
            'children' => [
                'referer' => [
                    'label'     => 'Referrers',
                    'icon'      => 'bi bi-file-earmark-text',
                    'url'       => 'referral',
                    'submodule' => 'referrer',
                ],
                'withdrawal' => [
                    'label'     => 'Withdrawals',
                    'icon'      => 'bi bi-file-earmark-text',
                    'url'       => 'referral/withdrawals',
                    'submodule' => 'withdrawal',
                ],
            ],
        ],
    ];
}
