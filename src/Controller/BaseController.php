<?php

namespace App\Controller;

abstract class BaseController 
{
    protected function render($template, $data)
    {
        $data['session_username'] = \App\Utils\Session::GetUsername();
        return \App\View\Twig::getInstance()->render($template, $data);
    }
}
