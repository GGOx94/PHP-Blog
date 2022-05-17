<?php

require '../vendor/autoload.php';
$routes = require '../config/routes.php';

try 
{
    $req = createController($_SERVER['REQUEST_URI'], $routes);

    App\Utils\Session::Start();
    
    $response = $req[0]($req[1]); // Call the _invoke of the controller with its potential args

    if ($response) {
        echo $response;
    }
    else {
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
    
    echo 'EXCEPTION TRIGGERED | ROUTER : ' . $e->getMessage(); // Todo : customize runtime errors
}

function createController($path, $routes) : array
{
    foreach ($routes as $uri => $route)
    {
        if (preg_match('`^' . $uri . '$`', $path, $groupMatches)) 
        {
            $params = null;

            if(count($groupMatches) > 1) {
                $params = array_slice($groupMatches, 1);
            }
            
            return [new $route(), $params];
        }
    }

    throw new Exception('HTTP/1.0 404 Not Found');
}
