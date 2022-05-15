<?php

namespace App\Controller;

class PostsListController extends BaseController
{
    public function __invoke()
    {
        $posts = $this->db->getAllPosts();
        $data = [
            'title' => 'Posts du Blog',
            'posts' => $posts
        ];
        
        return $this->render('postsList.twig', $data);
    }
}