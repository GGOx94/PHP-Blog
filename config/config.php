<?php 

namespace Config;

class Config 
{
    private static $_config = [
        'site_base_url' => 'http://localhost:8080',

        'db_user'       => 'ggo',
        'db_password'   => '',
        'db_host'       => 'localhost',
        'db_name'       => 'p5phpblog',

        'mailer_dsn'    => 'smtp://7b59807fb57e04:e40c746a29b73e@smtp.mailtrap.io:2525',
    ];

    public static function get($key) : ?string
    {
        if(!isset(self::$_config[$key])) {
            return null;
        }

        return self::$_config[$key];
    }
}