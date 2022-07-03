<?php

namespace App\Controller;

use App\Model\UserManager;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

use App\View\Twig;

class ContactController extends BaseController
{
    private UserManager $db;

    public function __construct()
    {
        $this->db = new UserManager();
    }

    public function __invoke() : string
    {
        if (empty($_POST)) {
            return $this->displayPage();
        }

        $name = \App\Utils\Post::GetOrThrow('name');
        $email = \App\Utils\Post::GetOrThrow('email');
        $message = \App\Utils\Post::GetOrThrow('message');

        $this->sendContactMail($name, $email, $message);
        return $this->displayMailSent($name, $email);
    }

    private function sendContactMail(string $name, string $email, string $message) : void
    {
        $transport = Transport::fromDsn(\Config\Config::get('mailer_dsn'));
        $mailer = new Mailer($transport);
        
        $data = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'siteUrl' => \Config\Config::get('site_base_url')
        ];

        $mail = (new Email())
            ->from($email)
            ->to('ggo@p5phpblog.net')
            ->subject('[Amazing Blog - Contact] : '.$name)
            ->text('Message reçu de la part de : '.$name.' ('.$email.') -> '.$message)
            ->html(Twig::getInstance()->render('mailContact.twig', $data)); 

        $mailer->send($mail);
    }

    private function displayMailSent(string $name) : string
    {
        $data = [
            'title' => 'Message envoyé !',
            'mail_sent' => true,
            'name' => $name
        ];

        return $this->render('contact.twig', $data);
    }

    private function displayPage() : string
    {
        $data = [
            'title' => 'Me contacter'
        ];

        // Pre-fill contact form if user is already logged-in
        if(\App\Utils\Session::IsLogged()) 
        {
            $data['user_name'] = \App\Utils\Session::GetUsername();
            $data['user_email'] = $this->db->getUserEmail($data['user_name']);
        }

        return $this->render('contact.twig', $data);
    }
}