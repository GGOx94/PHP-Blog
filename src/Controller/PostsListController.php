<?php

namespace App\Controller;

class PostsListController extends BaseController
{
    private $db;
    
    public function __construct()
    {
        $this->db = new \App\Model\PostManager();
    }

    public function __invoke() : string
    {
        $data = [
            'title' => 'Les Posts du Blog',
            'posts' => $this->db->getAllPosts()
        ];

        return $this->render('postsList.twig', $data);
    }
}