<?php 

namespace Config;

class Config 
{
    private static $_config = [
        'db_user'       => 'ggo',
        'db_password'   => '',
        'db_host'       => 'localhost',
        'db_name'       => 'p5phpblog'
    ];

    public static function get($key) : string
    {
        if(!isset(self::$_config[$key])) {
            return null;
        }

        return self::$_config[$key];
    }
}