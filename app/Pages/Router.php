<?php

namespace App\Pages;

class Router
{
    public static array $router = [
        '/' => [
            'template' => '/home/template',
            'preload' => true,
        ],
        0 => 'notfound',
        1 => '/intro',
        2 => '/masuk',
        3 => '/aktivasi',
        4 => '/pengumuman',
        5 => '/registrasi',
        6 => '/registrasi/confirm',
        7 => '/reset_password',
        8 => '/reset_password/change/:token',
        9 => '/page/:slug',
        10 => '/certificate/:id',
        '/courses' => [
            'preload' => true,
        ],
        '/courses/intro/:course_id/:slug/live_session' => [
            'preload' => true,
        ],
        '/courses/intro/:course_id/:slug/live_session/:live_id' => [
            'template' => '/courses/intro/live_session/detail/template',
            'preload' => true,
        ],
        '/courses/intro/:course_id/:slug/student' => [
            'preload' => true,
        ],
        '/courses/intro/:course_id/:slug/student/:id' => [
            'template' => '/courses/intro/student/detail/template',
            'preload' => true,
        ],
        11 => '/courses/intro/;course_id/:slug/tanya_jawab',
        '/courses/intro/:course_id/:slug' => [
            'preload' => true,
        ],
        '/courses/lessons/:id' => [
            'preload' => true,
        ],
        12 => '/courses/quiz/:id',
        '/pustaka' => [
            'handler' => '[isLoggedIn]',
        ],
        13 => '/courses/tanya_jawab',
        '/courses/tanya_jawab/:id' => [
            'template' => '/courses/tanya_jawab/detail/template',
        ],
        14 => '/feeds',
        '/feeds/:id' => [
            'template' => '/feeds/detail/template/:id',
        ],
        15 => '/checkout/:token?',
        16 => '/kajian',
        '/kajian/:id' => [
            'template' => '/kajian/detail/template',
        ],
        '/profile' => [
            'preload' => true,
        ],
        17 => '/profile/delete',
        18 => '/profile/edit_info',
        19 => '/profile/edit_account',
        20 => '/program_pesantren',
        21 => 'admin/list_tagihan',
        22 => 'admin/list_tagihan/generate',
        '/notification' => [],
        '/webpush' => [],
    ];
}