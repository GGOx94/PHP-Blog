<?php

use App\Controller\HomeController;
use App\Controller\PostsListController;
use App\Controller\PostController;

$routes = 
[
    'postsList'    => PostsListController::class,
    'post'         => PostController::class,
];

function getControllerAndArgs($path)
{  
    global $routes;

    if($path === '/') {
        return [new HomeController(), null];
    }

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
