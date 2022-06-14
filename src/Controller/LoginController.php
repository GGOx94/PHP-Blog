<?php

namespace App\Controller;

class LoginController extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = new \App\Model\UserManager();
    }

    public function __invoke()
    {
        if (\App\Utils\Session::IsLogged()) {
            return $this->displayPage('Bonjour, ' . $_SESSION['username']);
        }

        if (!$_POST) {
            return $this->displayPage('Se connecter');
        }

        $email = \App\Utils\Post::GetOrThrow('email');
        $password = \App\Utils\Post::GetOrThrow('password');

        return $this->loginUser($email, $password);
    }

    private function loginUser($email, $password)
    {
        $user = $this->db->getUserByCredentials($email, $password);

        if(!$user) {
            return $this->displayError("Mauvais identifiant ou mot de passe");
        }

        if($user->getStatus() === 'signing_up') {
            return $this->displayError("Vous n'avez pas activé votre compte, vérifiez votre boîte mail");
        }

        \App\Utils\Session::SetUserVars($user);
        return header('location: /');
    }

    private function displayPage($title)
    {
        $data = ['title' => $title];
        return $this->render('login.twig', $data);
    }

    private function displayError(string $errMsg)
    {
        $data = ['title' => 'Se connecter'];
        $data['error_messages'] = [$errMsg];

        return $this->render('login.twig', $data);
    }
}