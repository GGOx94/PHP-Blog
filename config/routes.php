<?php

namespace Config;

class Routes 
{
    private static $_routes = [
        '/'                 => \App\Controller\HomeController::class,
        '/postsList'        => \App\Controller\PostsListController::class,
        '/post'             => \App\Controller\PostController::class,
        '/post/([0-9]+)'    => \App\Controller\PostController::class,
        '/login'            => \App\Controller\LoginController::class,
        '/logout'           => \App\Controller\LogoutController::class,
        '/signup'           => \App\Controller\SignupController::class
    ];

    public static function get() : array
    {
        return self::$_routes;
    }
}

