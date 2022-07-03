<?php

namespace App\Model;

abstract class BaseManager
{
    private static \PDO $cnx;
    
    protected static function getCnx() : \PDO
    {
        if (!isset(self::$cnx))
        {
            $host = \Config\Config::get('db_host');
            $name = \Config\Config::get('db_name');
            $user = \Config\Config::get('db_user');
            $password = \Config\Config::get('db_password');
            
            self::$cnx = new \PDO('mysql:host='.$host.';dbname='.$name.';charset=utf8', $user, $password);
        }

        return self::$cnx;
    }

    protected function getHash($baseStr) : string
    {
        return md5($baseStr);
    }
}