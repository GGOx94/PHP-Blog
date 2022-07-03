<?php

namespace Config;

class Routes 
{
    private static $_routes = [
        '/'                         => \App\Controller\HomeController::class,
        '/postsList'                => \App\Controller\PostsListController::class,
        '/post/([0-9]+)'            => \App\Controller\PostController::class,
        '/comment/([a-z]+)'         => \App\Controller\CommentController::class,
        '/login'                    => \App\Controller\LoginController::class,
        '/logout'                   => \App\Controller\LogoutController::class,
        '/signup'                   => \App\Controller\SignupController::class,
        '/signup/([a-f0-9]{64})'    => \App\Controller\SignupController::class,
        '/admin'                    => \App\Controller\AdminController::class,
        '/admin/([a-z]+)'           => \App\Controller\AdminController::class,
        '/contact'                  => \App\Controller\ContactController::class
    ];

    public static function get() : array
    {
        return self::$_routes;
    }
}