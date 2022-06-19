<?php

require '../vendor/autoload.php';

try 
{
    $req = App\Controller\BaseController::CreateFromUri($_SERVER['REQUEST_URI']);

    App\Utils\Session::Start();

    $response = $req[0]($req[1]); // Call the _invoke of the controller with its potential args
    if ($response) {
        echo $response;
    }
    else {
        throw new Exception("Un problème est survenu avec la page.");
    }
} 
catch (Exception $e) 
{
    echo App\Controller\ErrorController::Display($e);
}
