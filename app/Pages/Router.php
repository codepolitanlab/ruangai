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
        '/registrasi' => [],
        '/registrasi/confirm/:token' => [],
        '/masuk' => [],
        '/masuk/instant/:token' => [
            'template' => '/masuk/instant/template',
        ],
        '/masuk/sebagai/:key' => [
            'template' => '/masuk/sebagai/template',
        ],
        '/page/:slug' => [],
        '/profile' => [],
        '/profile/edit_info' => [],
        '/profile/edit_account' => [],
        '/voucher/' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/certificate' => [],
        '/certificate/:code' => [
            'template' => '/certificate/detail/template',
        ],
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
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/courses/intro/:course_id/:slug' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/courses/:course_id/lesson/:lesson_id' => [
            'template' => '/courses/lesson/template',
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/courses/reward' => [
            'template' => '/courses/reward/template',
            'handler' => '[isLoggedIn]',
        ],
        '/courses/reward/claim' => [
            'template' => '/courses/reward/claim/template',
            'handler' => '[isLoggedIn]',
        ],
        '/courses/zoom/:meeting_code' => [
            'handler' => '[isLoggedIn]',
        ],
        '/courses/feedback/:meeting_code' => [
            'handler' => '[isLoggedIn]',
        ],
        '/courses/claim_certificate/:course_id' => [
            'handler' => '[isLoggedIn]',
        ],
        '/comentor' => [
            'handler' => '[isLoggedIn]',
        ],
        '/reset_password' => [],
        '/reset_password/change/:token' => [],
        '/courses/reward/howto' => [],
        '/challenge' => [],
        '/challenge/submit' => [],
        '/workshop' => [],
        '/prompts' => [],
    ];
}