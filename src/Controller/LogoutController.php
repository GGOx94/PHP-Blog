<?php

namespace App\Controller;

class LogoutController extends BaseController
{
    public function __invoke()
    {
        if(isset($_SESSION['username']))
        {
            unset($_SESSION['username']);
            session_destroy();
        }
        
        header('location: /');
    }
}