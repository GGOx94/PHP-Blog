<?php

namespace App\Controller;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

use App\View\Twig;

class SignupController extends BaseController
{
    private $errArr = [];
    private \App\Model\UserManager $userDb;

    public function __construct()
    {
        $this->userDb = new \App\Model\UserManager();
    }

    public function __invoke(?array $args) : string
    {
        if(isset($args[0])) // arg[0] should be a token from a registration link
        {
            $token = $args[0];
            if(!$this->userDb->isTokenValid($token)) 
            {
                $this->errArr[] = "Le jeton d'enregistrement a expiré ou est invalide.<br/>
                    Si vous souhaitiez créer un compte, essayez à nouveau.";
                return $this->displayErrors();
            }

            $rslt = $this->userDb->registerUser($token);
            if(!$rslt) 
            {
                $this->errArr[] = "Un problème est survenu lors de l'enregistrement.";
                return $this->displayErrors();
            }

            return $this->displaySuccess();
        }

        
        $pwd1 = \App\Utils\Post::GetOrThrow('password');
        $pwd2 = \App\Utils\Post::GetOrThrow('password-2');
        $name = \App\Utils\Post::GetOrThrow('name');
        $email = \App\Utils\Post::GetOrThrow('email');

        if($pwd1 !== $pwd2) {
            $this->errArr[] = "Les mots de passe ne correspondent pas.";
        }

        if($this->userDb->checkUserExists($name)) {
            $this->errArr[] = "Ce pseudonyme est déjà utilisé.";
        }

        if($this->userDb->checkEmailExists($email)) {
            $this->errArr[] = "Cet e-mail est déjà enregistré.";
        }
        
        if(!preg_match("/^([\pL\pN ]){3,20}$/u", $name)) {
            $this->errArr[] = "Le nom d'utilisateur doit faire 3 à 20 caractères, sans symboles.";
        }

        if(!preg_match('/^(?=.*\d)(?=.*[A-Z])[0-9A-Za-z]{8,50}$/', $pwd1)) {
            $this->errArr[] = "Le mot de passe doit faire 8 à 50 caractères et contenir au moins :<br/> une majuscule, une minuscule et un chiffre.";
        }

        if(count($this->errArr) > 0) {
            return $this->displayErrors();
        }

        $token = $this->userDb->preRegisterUser($name, $email, $pwd1);
        $this->sendRegistrationMail($name, $email, $token);
        return $this->displayMailSent($name, $email);
    }

    private function sendRegistrationMail(string $name, string $email, string $token) : void
    {
        $transport = Transport::fromDsn(\Config\Config::get('mailer_dsn'));
        $mailer = new Mailer($transport);

        // Create the data array of twig variables for the mail HTML template
        $siteUrl = \Config\Config::get('site_base_url');
        $signupUrl = $siteUrl . '/signup/' . $token;
        $data = [
            'name' => $name,
            'token' => $token,
            'siteUrl' => $siteUrl,
            'signupUrl' => $signupUrl
        ];

        $mail = (new Email())
            ->from('noreply@p5phpblog.net')
            ->to($email)
            ->subject('[Amazing Blog] Création de compte : ' . $name)
            ->text('Suivez ce lien pour valider l\'enregistrement de votre compte : ' . $signupUrl)
            ->html(Twig::getInstance()->render('mailSignup.twig', $data));

        $mailer->send($mail);
    }

    private function displayMailSent(string $name, string $email) : string
    {
        $data = [
            'title' => 'Mail de confirmation envoyé !',
            'mail_sent' => true,
            'name' => $name,
            'email' => $email
        ];

        return $this->render('login.twig', $data);
    }

    private function displaySuccess() : string
    {
        $data = [
            'title' => 'Bienvenu !',
            'signup_success' => true
        ];

        return $this->render('login.twig', $data);
    }

    private function displayErrors() : string
    {
        $data = [
            'title' => 'Se connecter',
            'error_messages' => $this->errArr
        ];

        return $this->render('login.twig', $data);
    }
}