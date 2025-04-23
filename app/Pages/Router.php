<?php

namespace App\Pages;

class Router
{
    public static array $router = [
        "/" => [
            'template' => '/home/template',
            'preload'  => true
        ],
        "notfound",
        "/intro",
        "/masuk",
        "/aktivasi",
        "/pengumuman",
        "/registrasi",
        "/registrasi/confirm",
        "/reset_password",
        "/reset_password/change/:token",
        "/page/:slug",
        "/certificate/:id",
        "/courses" => [
            "preload" => true,
        ],
        "/courses/intro/:course_id/:slug/live_session",
        "/courses/intro/:course_id/:slug/live_session/:live_id" => [
            'template' => '/courses/intro/live_session/detail/template',
        ],
        "/courses/intro/:course_id/:slug/student",
        "/courses/intro/:course_id/:slug/student/:id" => [
            'template' => '/courses/intro/student/detail/template',
        ],
        "/courses/intro/;course_id/:slug/tanya_jawab",
        "/courses/intro/:course_id/:slug",
        "/courses/lessons/:id",
        "/courses/quiz/:id",
        "/pustaka" => [
            "handler" => "[isLoggedIn]"
        ],
        "/courses/tanya_jawab",
        "/courses/tanya_jawab/:id" => [
            'template' => '/courses/tanya_jawab/detail/template',
        ],
        "/feeds",
        "/feeds/:id" => [
            'template' => '/feeds/detail/template/:id',
        ],
        "/checkout/:token?",
        "/kajian",
        "/kajian/:id" => [
            'template' => '/kajian/detail/template',
        ],
        "/profile" => [
            'preload' => true
        ],
        "/profile/delete",
        "/profile/edit_info",
        "/profile/edit_account",
        "/program_pesantren",
        "admin/list_tagihan",
        "admin/list_tagihan/generate",
    ];
}