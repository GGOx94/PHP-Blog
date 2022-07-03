<?php

namespace App\Controller;

class LogoutController extends BaseController
{
    public function __invoke() : void
    {
        \App\Utils\Session::Destroy();
        header('location: /');
    }
}