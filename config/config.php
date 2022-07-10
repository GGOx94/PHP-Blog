<?php 

namespace Config;

class Config 
{
    private static $_config = [
        'site_base_url' => '', // ex : 'http://localhost:80'

        'db_user'       => '', // ex : 'root'
        'db_password'   => '', 
        'db_host'       => '', // ex : 'localhost'
        'db_name'       => 'p5phpblogDEMO', // p5phpblogDEMO is the db_name if you executed the sql script without edits

        'mailer_dsn'    => '', // ex, for Mailtrap : smtp://[USER]:[PASSWD]@smtp.mailtrap.io:2525
    ];

    public static function get($key) : ?string
    {
        if(!isset(self::$_config[$key])) {
            return null;
        }

        return self::$_config[$key];
    }
}