<?php

require '../vendor/autoload.php';
require '../config/routes.php';

$uri = $_SERVER['REQUEST_URI'];
$req = getControllerAndArgs($uri);

if(!$req)
{
    header('HTTP/1.0 404 Not Found'); //TODO 404 in ERROR page
    exit(0);
}

try 
{
    $response = $req[0]($req[1]);

    if ($response)
    {
        echo $response;
    }  
    else
    {
        //TODO display ERROR page
    }
}
catch(Exception $e)
{
    //TODO display ERROR
    echo 'EXCEPTION IN ROUTER : ' . $e;
}


