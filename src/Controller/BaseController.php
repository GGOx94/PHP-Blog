<?php

//require_once('vendor/autoload.php');

namespace App\Controller;
use App\Model\Manager;

class BaseController 
{
    protected $twig;
    protected $db;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('..\src\Views');
        $this->twig = new \Twig\Environment($loader);
        $this->db = new Manager();
    }
}
