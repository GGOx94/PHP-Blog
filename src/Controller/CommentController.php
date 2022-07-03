<?php

namespace App\Controller;
use RuntimeException;

class CommentController extends BaseController
{
    private \App\Model\CommentManager $comDb;

    public function __construct()
    {
        $this->comDb = new \App\Model\CommentManager;
    }

    public function __invoke(array $action) : void
    {
        // Sensitive page : check user login status, will refresh session ID in the process
        if(!\App\Utils\Session::IsLogged()) {
            throw new RuntimeException('Vous devez être connecté pour poster un commentaire');
        }

        // The post ID that we came from, we'll redirect to that page after any actions
        $postId = \App\Utils\Post::GetOrThrow('postId', true); 

        if(count($action) == 0) {
            $this->throwBadAction();
        }

        switch($action[0])
        {
            case 'add':
                $comment = \App\Utils\Post::GetOrThrow('commentContent');
                $this->add($comment, $postId);
                break;

            case 'delete':
                $commentId = \App\Utils\Post::GetOrThrow('commentId', true);
                $this->delete($commentId);
                break;

            case 'approve':
                $commentId = \App\Utils\Post::GetOrThrow('commentId', true);
                $this->approve($commentId);
                break;

            default:
                $this->throwBadAction();
                break;
        }

        header('location: /post/' . $postId);
    }

    private function add(string $comment, int $postId) : void
    {
        $username = \App\Utils\Session::GetUsername();
        $isAdmin = \App\Utils\Session::IsUserAdmin();

        $rslt = $this->comDb->addOnPostID($postId, $comment, $username, $isAdmin);

        if(!$rslt) {
            throw new RuntimeException('Un problème est survenu lors de l\'enregistrement du commentaire.');
        }
    }

    private function delete(int $commentId) : void
    {
        if(!\App\Utils\Session::IsUserAdmin()) {
            $this->throwBadAction();
        }

        $rslt = $this->comDb->deleteById($commentId);

        if(!$rslt) {
            throw new RuntimeException('Un problème est survenu lors de la suppression du commentaire.');
        }
    }

    private function approve(int $commentId) : void
    {
        if(!\App\Utils\Session::IsUserAdmin()) {
            $this->throwBadAction();
        }

        $rslt = $this->comDb->approveById($commentId);

        if($rslt === false) {
            throw new RuntimeException('Un problème est survenu lors de la validation du commentaire.');
        }
    }

    private function throwBadAction() : void
    {
        throw new RuntimeException('Action demandée invalide.');
    }
}