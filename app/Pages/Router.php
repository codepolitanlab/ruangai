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
        '/masuk/instant/:token' => [
            'template' => '/masuk/instant/template',
        ],
        '/masuk/sebagai/:key' => [
            'template' => '/masuk/sebagai/template',
        ],
        '/masuk/:redirect*' => [],
        '/verify_email' => [],
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
        '/beasiswa' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/beasiswa/intro' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/beasiswa/intro/pdf_viewer' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/beasiswa/intro/live_session' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/beasiswa/intro/live_session/:live_id' => [
            'template' => '/beasiswa/intro/live_session/detail/template',
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/beasiswa/reward' => [
            'template' => '/beasiswa/reward/template',
            'handler' => '[isLoggedIn]',
        ],
        '/beasiswa/reward/claim' => [
            'template' => '/beasiswa/reward/claim/template',
            'handler' => '[isLoggedIn]',
        ],
        '/beasiswa/claim_certificate/:course_id' => [
            'template' => '/beasiswa/claim_certificate/template',
            'handler' => '[isLoggedIn]',
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
        '/courses/intro/:course_id/:slug/live_session/record/:meeting_id' => [
            'template' => '/courses/recording/template',
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
        '/prompt' => [],
        '/scholarship' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ]
    ];
}