<?php

namespace App\Controller;

class HomeController extends BaseController
{
    public function __invoke()
    {
        $data = ['title' => 'Amazing Blog !'];
        return $this->twig->render('home.twig', $data);
    }
}