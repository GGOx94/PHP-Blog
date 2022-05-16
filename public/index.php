<?php

require '../vendor/autoload.php';

define('__ROUTES__', require '../config/routes.php');

function createController($path) : array
{
    foreach (__ROUTES__ as $uri => $route)
    {
        if (preg_match('`^' . $uri . '$`', $path, $groupMatches)) 
        {
            $params = null;

            if(count($groupMatches) > 1)
            {
                $params = array_slice($groupMatches, 1);
            }
            
            return [new $route(), $params];
        }
    }

    throw new Exception('HTTP/1.0 404 Not Found');
}

try 
{
    $req = createController($_SERVER['REQUEST_URI']);

    session_start();

    $response = $req[0]($req[1]); // Call the _invoke of the controller with its potential args

    if ($response) 
    {
        echo $response;
    } 
    else 
    {
        throw new Exception("Un problème est survenu avec le controller.");
    }
} 
catch (Exception $e) 
{
    if(str_contains($e, 'HTTP/1.0'))
    {
        header($e->getMessage()); // Todo : customize 404/403/... errors
        exit(1);
    }
    
    echo 'EXCEPTION TRIGGERED TO ROUTER : ' . $e->getMessage(); // Todo : customize runtime errors
}


