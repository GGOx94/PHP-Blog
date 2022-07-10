<?php

namespace App\Controller;

class AdminController extends BaseController
{
    private \App\Model\CommentManager $dbComments;
    private \App\Model\PostManager $dbPosts;
    private \App\Model\UserManager $dbUsers;

    public function __construct()
    {
        $this->dbComments = new \App\Model\CommentManager();
        $this->dbPosts = new \App\Model\PostManager();
        $this->dbUsers = new \App\Model\UserManager();
    }

    public function __invoke(?array $action) : ?string
    {
        // Critical section: refresh session id by checking IsLogged and verify the user is an administrator
        if(!\App\Utils\Session::IsLogged() || !\App\Utils\Session::IsUserAdmin()) {
            throw new \Exception('HTTP/1.0 403 Forbidden');
        }

        // Admin panel requested with simple '/admin' URI
        if(!isset($action) || empty($action)) { 
            return $this->displayPostsPanel();
        }
        
        return $this->handleAction($action[0]);
    }

    private function handleAction(string $action) : ?string
    {
        // optionnal postId used for 'delete', 'edit' & 'post' action cases
        $postId = \App\Utils\Post::GetOrNull('postId', true); 

        switch($action)
        {
            case 'delete':
                return $this->deletePost($postId);

            case 'edit':
                return $this->displayPostEdit($postId);

            case 'post':
                $post = $this->buildPostInstance($postId);
                return $postId == 0 ? $this->createPost($post) : $this->updatePost($post);

            case 'users':
                return $this->displayUsersPanel();
            
            case 'userstatus':
                $name = \App\Utils\Post::GetOrThrow('userName');
                $status = \App\Utils\Post::GetOrThrow('userStatus');
                $this->setUserStatus($name, $status);
                return $this->displayUsersPanel();

            default:
                throw new \Exception('Action demandée invalide.');
        }
    }

    private function displayPostsPanel() : string
    {
        // Get all posts, then build their $comments array
        $posts = $this->dbPosts->getAllPosts();
        foreach($posts as $p) {
            $postComments = $this->dbComments->getCommentsOfPostID($p->getId());
            $p->setComments($postComments);
        }

        $data['title'] = 'Administration - Posts';
        $data['posts'] = $posts;

        return $this->render('adminPanel.twig', $data);
    }

    private function displayUsersPanel() : string
    {
        $users = $this->dbUsers->getRegularUsers();

        $data['title'] = 'Administration - Utilisateurs';
        $data['users'] = $users;

        return $this->render('adminUsers.twig', $data);
    }

    private function displayPostEdit(?int $postId) : string
    {
        $data = array();
        $data['title'] = $postId ? 'Éditer un Post' : 'Créer un Post';
        $data['post'] = $postId ? $this->dbPosts->getPostByID($postId) : null;
        
        return $this->render('adminPost.twig', $data);
    }

    private function updatePost(\App\Model\Post $post) : void
    {
        $rslt = $this->dbPosts->updatePost($post);
        if(!$rslt) {
            throw new \Exception('La mise à jour du Post a rencontré un problème.');
        }

        header('location: /post/' . $post->getId());
    }

    private function createPost(\App\Model\Post $post) : void
    {
        $newPostId = $this->dbPosts->createPost($post, \App\Utils\Session::GetUsername());
        if($newPostId == null) {
            throw new \Exception('La création du Post a rencontré un problème.');
        }

        header('location: /post/' . $newPostId);
    }

    private function deletePost(int $postId) : string
    {
        $rslt = $this->dbPosts->deletePost($postId);
        if(!$rslt) {
            throw new \Exception('La suppression du Post a rencontré un problème.');
        }

        return $this->displayPostsPanel();
    }

    private function buildPostInstance(?int $postId) : \App\Model\Post
    {
        $post = (new \App\Model\Post())
            ->setId($postId)
            ->setTitle(\App\Utils\Post::GetOrThrow('title'))
            ->setHead(\App\Utils\Post::GetOrThrow('head'))
            ->setContent(\App\Utils\Post::GetOrThrow('content')); 

        return $post;
    }

    private function setUserStatus(string $name, string $status) : bool
    {
        if($status === "banned") {
            return $this->dbUsers->banUser($name);
        }
        else if($status === "visitor") {
            return $this->dbUsers->unbanUser($name);
        }
            
        throw new \Exception("Mauvais status d'utilisateur envoyé au controlleur.");
    }
}
