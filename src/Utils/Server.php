<?php

namespace App\Utils;

class Server
{
    public static function GetUri() : ?string
    {
        if(!isset($_SERVER) || empty($_SERVER)) {
            return null;
        }

        return isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
    }

    public static function Log($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('[PHP]: " . $output . "' );</script>";
    }
}