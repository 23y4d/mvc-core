<?php declare(strict_types=1);

namespace app\core\classes;

class response 
{

    public static function setStatusCode($code) 
    {
        return http_response_code((int) $code) ;
    }



    public static function redirect($location = null,  $code = 301) 
    {
        if (!headers_sent()) {
            if ($code !== 301) self::setStatusCode($code);
            header('Location: ' . $location, TRUE, $code);
            exit;
        }
    }


    public static function jsonEncode($data) 
    {
        $result = json_encode($data, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT);
        if(json_last_error() === JSON_ERROR_NONE) {
            return $result;
        }
    }

    public static function jsonDecode($data) 
    {
        $result = json_decode($data, true);
        if(json_last_error() === JSON_ERROR_NONE) {
            return $result;
        }
    }


}
    
