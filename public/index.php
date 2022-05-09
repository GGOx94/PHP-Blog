<?php

require '../vendor/autoload.php';
$uri = $_SERVER['REQUEST_URI'];
$routes = require_once '../config/routes.php';

if (array_key_exists($uri, $routes))
{
    $ctrlName = $routes[$uri];
    $ctrler = new $ctrlName[0]();
    $response =  $ctrler();
    if ($response )
    {
        echo $response;
    }  
    else
    {
        //TODO display ERRzezedfsdsdsqdsqdsdsdsdsd
    }

    exit(0);
}

echo 'NOPE';
// header('HTTP/1.0 404 Not Found');