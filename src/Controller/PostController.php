<?php

namespace App\Controller;

use RuntimeException;

class PostController extends BaseController
{
    public function __invoke(array $args)
    {
        if(!$args) {
            throw new RuntimeException("Aucun ID de post précisé.");
        }

        $post = $this->db->getPostByID($args[0]);
        if(!$post) {
            throw new RuntimeException("Ce post n'existe pas.");
        }

        $comments = $this->db->getCommentsOfPostID($args[0]);
        
        $data = [
            'title' => $post->getTitle(),
            'post' => $post,
            'comments' => $comments
        ];
        
        return $this->render('post.twig', $data);
    }
}