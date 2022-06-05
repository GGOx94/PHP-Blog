<?php

require '../vendor/autoload.php';

try 
{
    $req = createController($_SERVER['REQUEST_URI']);

    App\Utils\Session::Start();

    if(isset($_POST['pouet']))
    {
        echo 'coucou';
        exit(42);
    }
    
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
    
    // Todo : customize runtime errors
    echo '<br/><p style="background-color:red;color:white">EXCEPTION TRIGGERED | ROUTER : ' . $e->getMessage() . '</p>'; 
}

function createController($path) : array
{
    foreach (\Config\Routes::get() as $uri => $controller)
    {
        if (preg_match('`^' . $uri . '$`', $path, $groupMatches)) 
        {
            $params = null;

             // If we find any group matches : we have additional parameters
            if(count($groupMatches) > 1) 
            {
                $params = array_slice($groupMatches, 1);
            }
            
            return [new $controller(), $params];
        }
    }

    throw new Exception('HTTP/1.0 404 Not Found');
}
