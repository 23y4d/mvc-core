<?php 
namespace app\core\errorhandlers;

class phperrorhandler {
	
	public static function phphandle($errno, $errstr, $errfile, $errline) {
		if (error_reporting() & $errno) {
            throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
        }
        return true;
	}
}