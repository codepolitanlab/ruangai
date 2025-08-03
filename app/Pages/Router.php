<?php

namespace App\Pages;

class Router
{
    public static array $router = [
        '/' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        'notfound' => [
            'preload' => true,
        ],
        // '/intro' => [],
        '/masuk'                => [],
        '/masuk/instant/:token' => [
            'template' => '/masuk/instant/template',
        ],
        '/masuk/sebagai/:key' => [
            'template' => '/masuk/sebagai/template',
        ],
        // '/pengumuman' => [],
        // '/registrasi' => [],
        // '/registrasi/confirm' => [],
        // '/reset_password' => [],
        // '/reset_password/change/:token' => [],
        // '/page/:slug' => [],
        '/certificate/claim/:course_id' => [
            'handler' => '[isLoggedIn]',
        ],
        '/voucher/' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/certificate/:code' => [],
        '/courses' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/courses/intro/:course_id/:slug/lessons' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/courses/intro/:course_id/:slug/live_session' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/courses/intro/:course_id/:slug/live_session/:live_id' => [
            'template' => '/courses/intro/live_session/detail/template',
            'preload'  => true,
            'handler'  => '[isLoggedIn]',
        ],
        '/courses/intro/:course_id/:slug' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/courses/:course_id/lesson/:lesson_id' => [
            'template' => '/courses/lesson/template',
            'preload'  => true,
            'handler'  => '[isLoggedIn]',
        ],
        '/courses/:course_id/reward' => [
            'template' => '/courses/reward/template',
            'handler'  => '[isLoggedIn]',
        ],
        // '/courses/tanya_jawab' => [],
        // '/courses/tanya_jawab/:id' => [
        //     'template' => '/courses/tanya_jawab/detail/template',
        // ],
        // '/profile' => [
        //     'preload' => true,
        //     'handler' => '[isLoggedIn]',
        // ],
        // '/profile/delete' => [
        //     'preload' => true,
        //     'handler' => '[isLoggedIn]',
        // ],
        // '/profile/edit_info' => [
        //     'preload' => true,
        //     'handler' => '[isLoggedIn]',
        // ],
        // '/profile/edit_account' => [
        //     'preload' => true,
        //     'handler' => '[isLoggedIn]',
        // ],
        // '/notification' => [
        //     'handler' => '[isLoggedIn]',
        // ],
        // '/webpush' => [
        //     'handler' => '[isLoggedIn]',
        // ],
    ];
}
