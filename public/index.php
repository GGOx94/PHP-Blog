<?php

require '../vendor/autoload.php';
require '../config/routes.php';

$uri = $_SERVER['REQUEST_URI'];
$req = createController($uri);

session_start();

if(!$req)
{
    header('HTTP/1.0 404 Not Found'); //TODO 404 in ERROR page
    exit(0);
}

try 
{
    $response = $req[0]($req[1]); // Call the _invoke of the controller with its potential args

    if ($response)
    {
        echo $response;
    }  
    else
    {
        //TODO display home page with error ? error page ?
    }
}
catch(Exception $e)
{
    //TODO display ERROR
    echo 'EXCEPTION IN ROUTER : ' . $e;
}


