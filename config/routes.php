<?php

use App\Controller\HomeController;
use App\Controller\PostsListController;
use App\Controller\PostController;
use App\Controller\LoginController;
use App\Controller\LogoutController;

$routes = 
[
    'postsList'    => PostsListController::class,
    'post'         => PostController::class,
    'login'        => LoginController::class,
    'logout'        => LogoutController::class
];

function createController($path)
{
    if($path === '/') {
        return [new HomeController(), null];
    }

    global $routes;

    $values = explode('/', $path);
    for($i = 0; $i < count($values); $i++)
    {
        $curVal = $values[$i];
        if(array_key_exists($curVal, $routes))
        {
            $controller = new $routes[$curVal]();
            
            return [ 
                $controller, 
                $i < count($values) - 1 ? array_slice($values, $i + 1) : null
            ];
        }
    }
    
    return null;
}

function setupSession()
{
    
}
