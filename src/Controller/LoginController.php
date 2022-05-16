<?php

namespace App\Controller;

class LoginController extends BaseController
{
    public function __invoke()
    {
        if (isset($_SESSION['username'])) {
            return $this->displayPage('Bonjour, ' . $_SESSION['username']);
        }

        if (!$_POST) {
            return $this->displayPage('Se connecter');
        }

        if (isset($_POST['email']) && isset($_POST['password'])) {
            return $this->loginUser($_POST['email'], $_POST['password']);
        }

        return $this->displayErrors();
    }

    private function loginUser($email, $password)
    {
        $user = $this->db->loginUser($email, $password);

        if ($user) // Success : User is logged-in, set session and redirect to homepage
        {
            $_SESSION['username'] = $user->getName();
            header('location: /');
            return;
        }

        return $this->displayErrors();
    }

    private function displayPage($title)
    {
        $data = ['title' => $title];
        return $this->render('login.twig', $data);
    }

    private function displayErrors()
    {
        // Only one error possible in login : wrong email/password

        $data = ['title' => 'Se connecter'];
        $data['error_messages'] = ["Mauvais email ou mot de passe."];

        return $this->render('login.twig', $data);
    }
}