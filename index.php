<?php

require_once('controller/frontend.php');

try 
{
    if(!isset($_GET['action'])) // Serve landing page
    {
        welcome(); 
        return;
    }
        
    // TODO
    switch($_GET['action'])
    {
        case 'listPosts':
            echo 'Action demandée : lister les posts';
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
    error($e_str);
}
