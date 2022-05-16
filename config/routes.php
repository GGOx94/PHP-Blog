<?php

use App\Controller\HomeController;
use App\Controller\PostsListController;
use App\Controller\PostController;
use App\Controller\LoginController;
use App\Controller\LogoutController;
use App\Controller\SignupController;

return [
    '/' => HomeController::class,
    '/postsList' => PostsListController::class,
    '/post' => PostController::class,
    '/post/([0-9]+)' => PostController::class,
    '/login' => LoginController::class,
    '/logout' => LogoutController::class,
    '/signup' => SignupController::class
];

