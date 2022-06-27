<?php

namespace App\Controller;

abstract class BaseController 
{
    // All controllers use this function to render their twig templates
    // We set sessions variables for twig (username, isAdmin, ...) from here
    protected function render($template, $data) : string
    {
        $data['session_username'] = \App\Utils\Session::GetUsername();
        $data['session_isAdmin'] = \App\Utils\Session::IsUserAdmin();
        return \App\View\Twig::getInstance()->render($template, $data);
    }

    public static function CreateFromUri($path) : array
    {
        foreach (\Config\Routes::get() as $uri => $controller)
        {
            if (preg_match('`^' . $uri . '$`', $path, $groupMatches)) 
            {
                $params = null;

                // If we find more than one group matches : we have additional parameters
                if(count($groupMatches) > 1) 
                {
                    $params = array_slice($groupMatches, 1);
                }
                
                return [new $controller(), $params];
            }
        }

        throw new \Exception('HTTP/1.0 404 Not Found');
    }
}