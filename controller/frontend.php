<?php

require_once('vendor/autoload.php');
require_once('model/Manager.php');

class Frontend 
{
    private $twig;
    private $db;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('./view/templates');
        $this->twig = new \Twig\Environment($loader);

        $this->db = new Manager();
    }

    public function displayWelcome()
    {
        $data = ['title' => 'Amazing Blog !'];
        $this->render('welcome.twig', $data);
    }

    public function displayPosts()
    {
        $posts = $this->db->getAllPosts();
        $data = [
            'title' => 'Posts du Blog',
            'posts' => $posts
        ];
        
        $this->render('postsList.twig', $data);
    }

    public function displayError($errStr)
    {
        $data = ['error_str' => $errStr];
        $this->render('error.twig', $data);
    }

    private function render($template, $attribs = [])
    {
        echo $this->twig->render($template, $attribs);
    }
}
