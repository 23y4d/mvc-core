<?php //declare(strict_types=1);


namespace app\core;



class autoload
 {

    public static function Load($className)
    {
        $className = str_replace(['App','\\'],['','/'] ,$className);
        $className = $className.'.php';
        $appPath = realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR .'../';
        if(file_exists($appPath . $className)) {
            require_once $appPath . $className;
        }
    }


}
spl_autoload_register(__NAMESPACE__.'\autoload::load');