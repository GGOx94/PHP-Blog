<?php

namespace App\Controller;

use RuntimeException;

class PostController extends BaseController
{
    public function __invoke($args)
    {
        if(!$args || !is_numeric($args[0])) {
            throw new RuntimeException("Mauvais ID de Post précisé.");
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
        
        return $this->twig->render('post.twig', $data);
    }
}