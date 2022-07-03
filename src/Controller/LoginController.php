<?php

namespace App\Controller;

class LoginController extends BaseController
{
    private \App\Model\UserManager $userDb;

    public function __construct()
    {
        $this->userDb = new \App\Model\UserManager();
    }

    public function __invoke() : ?string
    {
        if (\App\Utils\Session::IsLogged()) {
            return $this->displayPage('Bonjour, ' . \App\Utils\Session::GetUsername());
        }

        if (\App\Utils\Post::IsEmpty($_POST)) {
            return $this->displayPage('Se connecter');
        }

        $email = \App\Utils\Post::GetOrThrow('email');
        $password = \App\Utils\Post::GetOrThrow('password');

        return $this->loginUser($email, $password);
    }

    private function loginUser(string $email, string $password) : ?string
    {
        $user = $this->userDb->getUserByCredentials($email, $password);

        if(!$user) {
            return $this->displayError("Mauvais identifiant ou mot de passe.");
        }

        if($user->getStatus() === 'banned') {
            return $this->displayError("Ce compte a été banni par un administrateur.");
        }

        if($user->getStatus() === 'signing_up') {
            return $this->displayError("Vous n'avez pas activé votre compte, vérifiez votre boîte mail.");
        }

        \App\Utils\Session::SetUserVars($user);
        
        return header('location: /');
    }

    private function displayPage(string $title) : string
    {
        $data = ['title' => $title];
        return $this->render('login.twig', $data);
    }

    private function displayError(string $errMsg) : string
    {
        $data = ['title' => 'Se connecter'];
        $data['error_messages'] = [$errMsg];

        return $this->render('login.twig', $data);
    }
}