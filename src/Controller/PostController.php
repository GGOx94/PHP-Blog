<?php

namespace App\Controller;

use RuntimeException;

class PostController extends BaseController
{
    private $dbPosts;
    private $dbComments;
    
    public function __construct()
    {
        $this->dbPosts = new \App\Model\PostManager();
        $this->dbComments = new \App\Model\CommentManager();
    }

    public function __invoke(array $args)
    {
        $post = $this->dbPosts->getPostByID($args[0]);
        if(!$post) {
            throw new RuntimeException("Ce post n'existe pas.");
        }

        $comments = $this->dbComments->getCommentsOfPostID($args[0]);
        
        $data = [
            'title' => $post->getTitle(),
            'post' => $post,
            'comments' => $comments
        ];
        
        return $this->render('post.twig', $data);
    }
}