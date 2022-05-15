<?php

namespace App\Controller;

class LoginController extends BaseController
{
    private $errMsg;

    public function __invoke()
    {
        if(!isset($_SESSION['username']))
        {
            if(!$_POST)
            {
                return $this->displayPage('Se connecter');
            }
            else if(isset($_POST['email']) && isset($_POST['password']))
            {
                return $this->loginUser($_POST['email'], $_POST['password']);
            }
            else
            {
                return $this->displayError();
            }
        }

        return $this->displayPage('Connecté : ' . $_SESSION['username']);
    }

    private function loginUser($email, $password)
    {
        $user = $this->db->loginUser($email, $password);

        if($user) // Success : User is logged-in, set session and redirect to homepage
        {
            $_SESSION['username'] = $user->getName();
            header('location: /');
            return;
        }

        return $this->displayError();
    }

    private function displayPage($title)
    {
        $data = [ 'title' => $title ];

        if($this->errMsg)
        {
            $data['error_message'] = $this->errMsg;
        }

        return $this->render('login.twig', $data);
    }

    private function displayError()
    {
        $this->errMsg = 'Mauvais email ou mot de passe.';
        return $this->displayPage('Se connecter');
    }
}