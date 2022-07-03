<?php

namespace App\Controller;

class PostsListController extends BaseController
{
    private \App\Model\PostManager $postDb;
    
    public function __construct()
    {
        $this->postDb = new \App\Model\PostManager();
    }

    public function __invoke() : string
    {
        $data = [
            'title' => 'Les Posts du Blog',
            'posts' => $this->postDb->getAllPosts()
        ];

        return $this->render('postsList.twig', $data);
    }
}