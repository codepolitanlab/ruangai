<?php

namespace App\Pages;

class Router
{
    public static array $router = [
        '/' => [
            'template' => '/home/template',
            'preload' => true,
        ],
        'notfound' => [
            'preload' => true,
        ],
        '/masuk' => [],
        '/masuk/instant/:token' => [
            'template' => '/masuk/instant/template',
        ],
        '/certificate/:id' => [
            'preload' => true,
            'handler' => '[isLoggedIn]',
        ],
        '/courses' => [],
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
        '/zpanel/configuration' => [],
    ];
}