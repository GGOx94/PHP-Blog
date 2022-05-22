<?php

namespace App\View;

class Twig 
{
    private static $twig;

    public static function getInstance()
    {   
        if (!isset(self::$twig)) 
        {
            $loader = new \Twig\Loader\FilesystemLoader('..\src\View\templates');
            self::$twig = new \Twig\Environment($loader);
        }

        return self::$twig;
    }

    private function __construct() {}
}