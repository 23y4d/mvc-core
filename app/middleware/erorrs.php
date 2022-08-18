<?php declare(strict_types=1);

namespace app\middleware;

use app\core\errorhandlers\exceptionhandler;
use app\core\errorhandlers\phperrorhandler;
use app\core\interfaces\middlewareInterface;

class erorrs implements middlewareInterface 
{

    public function call($request,$next) {
      
        error_reporting(-1);
        set_error_handler([phperrorhandler::class, 'phphandle']);
        set_exception_handler([exceptionhandler::class, 'exceptionhandle']);
        
     return $next($request);
        
    }
}
