<?php

namespace App\Controller;

class HomeController extends BaseController
{
    public function __invoke() : string
    {
        $data = ['title' => 'Amazing Blog !'];
        return $this->render('home.twig', $data);
    }
}