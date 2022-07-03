<?php

namespace App\Utils;

class Session
{
    public static function Start() : void
    {
        ini_set('session.use_strict_mode', 1); // Ensure strict mode
        session_start();
    }

    // Returns whether or not the current session holds user data
    // Performs a session ID regen in the process
    public static function IsLogged() : bool
    {
        if(session_status() != PHP_SESSION_ACTIVE) {
            Session::Start();
        }

        session_regenerate_id();

        return isset($_SESSION['username']);
    }

    public static function Destroy() : void
    {
        if(session_status() == PHP_SESSION_ACTIVE)
        {
            session_unset();
            session_destroy();
        }
    }

    public static function SetUserVars(\App\Model\User $user) : bool
    {
        if(session_status() != PHP_SESSION_ACTIVE) {
            Session::Start();
        }

        $_SESSION['username'] = $user->getName();
        $_SESSION['admin'] = $user->getStatus() === 'admin';

        return Session::IsLogged();
    }

    public static function GetUsername() : ?string
    { 
        return isset($_SESSION['username']) ? $_SESSION['username'] : null; 
    }

    public static function IsUserAdmin() : bool
    {
        return isset($_SESSION['admin']) && $_SESSION['admin'] == true;
    }
}