<?php declare(strict_types=1);

namespace app\middleware;

use app\core\classes\response;
use app\core\interfaces\middlewareInterface;


class underUpdate implements middlewareInterface
{

    public function call($request,$next) {
        
        response::setStatusCode(500);
        die('website under update ');
        
     return $next($request);
        
    }
}
