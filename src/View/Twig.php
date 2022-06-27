<?php

namespace App\View;

class Twig
{
    private static \Twig\Environment $_twig;

    public static function getInstance() : \Twig\Environment
    {
        if (!isset(self::$_twig))
        {
            $loader = new \Twig\Loader\FilesystemLoader('..\src\View\templates');
            self::$_twig = new \Twig\Environment($loader);
            self::$_twig->addExtension(new \Twig\Extra\Intl\IntlExtension());
        }

        return self::$_twig;
    }

    private function __construct() {}
}