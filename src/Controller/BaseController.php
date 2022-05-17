<?php

namespace App\Controller;
use App\Model\Manager;

abstract class BaseController 
{
    private $twig;
    protected $db;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('..\src\Views');
        $this->twig = new \Twig\Environment($loader);

        $this->db = new Manager();
    }

    protected function render($template, $data)
    {
        $username = \App\Utils\Session::GetUsername();
        if($username) {
            $this->twig->addGlobal('session_username', $username);
        }

        return $this->twig->render($template, $data);
    }
}
