<?php

require_once('controller/frontend.php');

if(!isset($controller))
    $controller = new Frontend();

try 
{
    if(!isset($_GET['action'])) // Serve landing page
    {
        // welcome(); 
        $controller->displayWelcome();
        return;
    }
        
    // TODO
    switch($_GET['action'])
    {
        case 'listPosts':
            $controller->displayPosts();
            break;
        case 'contact' : 
            echo 'Action demandée : page de contact';
            break;
        default:
            throw new Exception("Action incorrecte : " . $_GET['action']);
        break;
    }
    
}
catch(Exception $e) 
{
    $e_str = '[EXCEPTION_ROUTER] ' . $e->getMessage();
    $controller->displayError($e_str);
}
