<?php

namespace App\Controller;

abstract class BaseController 
{
    // All controler use this function to render their twig templates
    // We set sessions variables for twig (username, status) from here
    protected function render($template, $data)
    {
        $data['session_username'] = \App\Utils\Session::GetUsername();
        $data['session_isAdmin'] = \App\Utils\Session::IsUserAdmin();
        return \App\View\Twig::getInstance()->render($template, $data);
    }
}
