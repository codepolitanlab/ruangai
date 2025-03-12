<?php
$sidebar = [
    'dashboard' => [
        'label' => 'Dashboard',
        'icon' => 'bi bi-grid-fill',
        'url' => '/zpanel'
    ],
    'user' => [
        'label' => 'User Management',
        'icon' => 'bi bi-person',
        'url' => '#',
        'children' => [
            'list' => [
                'label' => 'Users',
                'icon' => 'bi bi-people',
                'url' => '/zpanel/user',
            ],
            'role' => [
                'label' => 'Roles',
                'icon' => 'bi bi-person-gear',
                'url' => '/zpanel/user/role',
            ],
        ]
    ],
    'content' => [
        'label' => 'Content',
        'icon' => 'bi bi-folder',
        'url' => '#',
        'children' => [
            'page' => [
                'label' => 'Pages',
                'icon' => 'bi bi-file-text',
                'url' => '/zpanel/content/pages',
            ],
            'microblog' => [
                'label' => 'Microblogs',
                'icon' => 'bi bi-chat-text',
                'url' => '/zpanel/content/microblogs',
            ],
            'files' => [
                'label' => 'Files',
                'icon' => 'bi bi-file-earmark',
                'url' => '/zpanel/content/files',
            ],
            'slider' => [
                'label' => 'Sliders',
                'icon' => 'bi bi-images',
                'url' => '/zpanel/content/sliders',
            ],
            'announcement' => [
                'label' => 'Announcements',
                'icon' => 'bi bi-megaphone',
                'url' => '/zpanel/content/announcements',
            ],
        ]
    ],
    'elearning' => [
        'label' => 'E-Learning',
        'icon' => 'bi bi-book',
        'url' => '#',
        'children' => [
            'online_class' => [
                'label' => 'Online Classes',
                'icon' => 'bi bi-laptop',
                'url' => '/zpanel/course',
            ],
            'quiz' => [
                'label' => 'Quizzes',
                'icon' => 'bi bi-ui-checks',
                'url' => '/zpanel/quiz',
            ],
            'live_class' => [
                'label' => 'Live Classes',
                'icon' => 'bi bi-camera-video',
                'url' => '/zpanel/elearning/live-classes',
            ],
        ]
    ],
    'transaction' => [
        'label' => 'Transactions',
        'icon' => 'bi bi-cash-stack',
        'url' => '#',
        'children' => [
            'voucher' => [
                'label' => 'Vouchers',
                'icon' => 'bi bi-ticket-perforated',
                'url' => '/zpanel/transactions/vouchers',
            ],
            'membership' => [
                'label' => 'Memberships',
                'icon' => 'bi bi-card-checklist',
                'url' => '/zpanel/transactions/memberships',
            ],
            'transaction' => [
                'label' => 'Transaction History',
                'icon' => 'bi bi-receipt',
                'url' => '/zpanel/transactions/history',
            ],
        ]
    ],
    'earning' => [
        'label' => 'Earnings',
        'icon' => 'bi bi-wallet2',
        'url' => '#',
        'children' => [
            'referral' => [
                'label' => 'Referral Earnings',
                'icon' => 'bi bi-person-plus',
                'url' => '/zpanel/earnings/referrals',
            ],
            'referral_partner' => [
                'label' => 'Referral Partners',
                'icon' => 'bi bi-people-fill',
                'url' => '/zpanel/earnings/referral-partners',
            ],
        ]
    ],
    'configuration' => [
        'label' => 'Configuration',
        'icon' => 'bi bi-gear',
        'url' => '#',
        'children' => [
            'setting' => [
                'label' => 'Settings',
                'icon' => 'bi bi-sliders',
                'url' => '/zpanel/configuration/settings',
            ],
            'navigation' => [
                'label' => 'Navigation',
                'icon' => 'bi bi-menu-button-wide',
                'url' => '/zpanel/configuration/navigation',
            ],
            'page_option' => [
                'label' => 'Page Options',
                'icon' => 'bi bi-tools',
                'url' => '/zpanel/configuration/page-options',
            ],
            'module' => [
                'label' => 'Modules',
                'icon' => 'bi bi-puzzle',
                'url' => '/zpanel/configuration/modules',
            ],
            'entry' => [
                'label' => 'Entries',
                'icon' => 'bi bi-pencil-square',
                'url' => '/zpanel/configuration/entries',
            ],
            'importer' => [
                'label' => 'Importer',
                'icon' => 'bi bi-upload',
                'url' => '/zpanel/configuration/importer',
            ],
            'exporter' => [
                'label' => 'Exporter',
                'icon' => 'bi bi-download',
                'url' => '/zpanel/configuration/exporter',
            ],
        ]
    ],
];

function renderMenu($menu) {
    echo '<div class="sidebar-menu">';
    echo '<ul class="menu">';

    foreach ($menu as $key => $item) {
        $hasChildren = isset($item['children']) && is_array($item['children']);

        echo '<li class="sidebar-item ' . ($hasChildren ? 'has-sub' : '') . '">';
        echo '<a href="' . htmlspecialchars($item['url']) . '" class="sidebar-link">';
        echo '<i class="' . htmlspecialchars($item['icon']) . '"></i>';
        echo '<span>' . htmlspecialchars($item['label']) . '</span>';
        echo '</a>';

        if ($hasChildren) {
            echo '<ul class="submenu">';
            foreach ($item['children'] as $subKey => $subItem) {
                echo '<li class="submenu-item">';
                echo '<a href="' . htmlspecialchars($subItem['url']) . '" class="submenu-link">';
                echo '<i class="' . htmlspecialchars($subItem['icon']) . '"></i>';
                echo '<span>' . htmlspecialchars($subItem['label']) . '</span>';
                echo '</a>';
                echo '</li>';
            }
            echo '</ul>';
        }

        echo '</li>';
    }

    echo '</ul>';
    echo '</div>';
}
?>

<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-center align-items-center">
                <div class="logo">
                    <a href="/zpanel">HeroicAdmin</a>
                </div>

                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>

        <?php renderMenu($sidebar); ?>

    </div>
</div>