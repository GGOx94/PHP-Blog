<?php

namespace App\Utils;

class Server
{
    public static function GetUri() : ?string
    {
        if(!isset($_SERVER) || empty($_SERVER)) {
            return null;
        }

        return isset($_SERVER['REQUEST_URI']) ? stripslashes($_SERVER['REQUEST_URI']) : null;
    }
}