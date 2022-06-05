<?php

namespace App\Controller;

class SignupController extends BaseController
{
    private $errArr = [];
    private $db;

    public function __construct()
    {
        $this->db = new \App\Model\UserManager();
    }

    public function __invoke()
    {
        $pwd1 = \App\Utils\Post::GetOrThrow('password');
        $pwd2 = \App\Utils\Post::GetOrThrow('password-2');
        $name = \App\Utils\Post::GetOrThrow('name');
        $email = \App\Utils\Post::GetOrThrow('email');

        if($pwd1 !== $pwd2) {
            $this->errArr[] = "Les mots de passe ne correspondent pas.";
        }

        if($this->db->checkUserExists($name)) {
            $this->errArr[] = "Ce pseudonyme est déjà utilisé.";
        }

        if($this->db->checkEmailExists($email)) {
            $this->errArr[] = "Cet e-mail est déjà enregistré.";
        }
        
        if(count($this->errArr) > 0) {
            return $this->displayErrors();
        }

        $this->registerUser($name, $email, $pwd1);
    }

    private function registerUser($name, $email, $pwd)
    {
        //TODO TMP : register & login user right away for now, but we need a proper mailer registration

        $rslt = $this->db->registerUser($name, $email, $pwd);

        if(!$rslt)
        {
            $this->errArr[] = "Un problème est survenu lors de l'enregistrement.";
            return $this->displayErrors();
        }

        $user = $this->db->loginUser($email, $pwd);

        if ($user) // Success : User is logged-in, set session and redirect to homepage
        {
            \App\Utils\Session::SetUserVars($user);
            return header('location: /');
        }

        $this->errArr[] = "Un problème est survenu lors de l'enregistrement.";
        return $this->displayErrors();
    }

    private function displayErrors()
    {
        $data = [
            'title' => 'Se connecter',
            'error_messages' => $this->errArr
        ];

        return $this->render('login.twig', $data);
    }
}