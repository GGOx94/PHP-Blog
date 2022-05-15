<?php

namespace App\Controller;

class RegisterController extends BaseController
{
    private $user;

    public function __invoke($args)
    {
        

        $data = ['title' => 'Amazing Blog !'];
        return $this->render('home.twig', $data);
    }

    private function loginUser()
    {
        
    }
}