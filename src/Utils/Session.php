<?php

namespace App\Utils;

class Session
{
    public static function Start()
    {
        ini_set('session.use_strict_mode', 1); // Ensure strict mode
        session_start();
    }

    // Returns whether or not the current session holds user data
    // Performs an session ID regeneration in the process
    public static function IsLogged() : bool
    {
        if(session_status() != PHP_SESSION_ACTIVE) {
            Session::Start();
        }

        session_regenerate_id();

        return isset($_SESSION['username']);
    }

    public static function Destroy()
    {
        if(session_status() == PHP_SESSION_ACTIVE)
        {
            session_unset();
            session_destroy();
            Session::Start();
        }
    }

    public static function SetUsername($username) : bool
    {
        if(session_status() != PHP_SESSION_ACTIVE) {
            Session::Start();
        }

        $_SESSION['username'] = $username;
        return Session::IsLogged();
    }

    public static function GetUsername() 
    { 
        return isset($_SESSION['username']) ? $_SESSION['username'] : null; 
    }
}
