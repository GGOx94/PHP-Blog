<?php

namespace App\Utils;

use Exception;
use RuntimeException;

class Post
{
    public static function GetOrThrow($varname, $isNum = false) : string
    {
        $value = (isset($_POST[$varname]) ? $_POST[$varname] : false);
        
        if($value === false) {
            self::ThrowPostException();
        }

        if($isNum && !is_numeric($_POST[$varname])) {
            self::ThrowPostException();
        }

        return $value;
    }

    public static function GetOrNull($varname, $isNum = false) : ?string
    {
        try {
            return self::GetOrThrow($varname, $isNum);
        }
        catch(Exception $e) {
            return null;
        }
    }


    private static function ThrowPostException()
    {
        throw new RuntimeException('Un problème est survenu avec les données envoyées.');
    }
}