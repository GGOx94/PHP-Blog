<?php 

namespace Config;

class Config 
{
    private static $_config = [
        'site_base_url' => '',

        'db_user'       => '',
        'db_password'   => '',
        'db_host'       => '',
        'db_name'       => '',

        'mailer_dsn'    => '',
    ];

    public static function get($key) : ?string
    {
        if(!isset(self::$_config[$key])) {
            return null;
        }

        return self::$_config[$key];
    }
}