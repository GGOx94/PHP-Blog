<?php

//require_once('vendor/autoload.php');

namespace App\Controller;
use App\Model\Manager;

class BaseController 
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
        if(isset($_SESSION['username']))
        {
            $this->twig->addGlobal('session_username', $_SESSION['username']);
        }

        return $this->twig->render($template, $data);
    }
}
