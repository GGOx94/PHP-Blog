<?php

namespace App\Controller;

use RuntimeException;

class PostController extends BaseController
{
    private \App\Model\PostManager $dbPosts;
    private \App\Model\CommentManager $dbComments;
    
    public function __construct()
    {
        $this->dbPosts = new \App\Model\PostManager();
        $this->dbComments = new \App\Model\CommentManager();
    }

    public function __invoke(array $args) : string
    {
        $post = $this->dbPosts->getPostByID($args[0]);
        if(!$post) {
            throw new RuntimeException("Ce post n'existe pas.");
        }

        $comments = $this->dbComments->getCommentsOfPostID($args[0]);
        
        $data = [
            'title' => $post->getTitle(),
            'post' => $post,
            'comments' => $comments,
            'postId' => $args[0]
        ];
        
        return $this->render('post.twig', $data);
    }
}