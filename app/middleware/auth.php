<?php declare(strict_types=1);

namespace app\middleware;

use app\core\classes\response;
use app\core\classes\session;
use app\core\interfaces\middlewareInterface;

class auth implements middlewareInterface 
{

    public function call($request,$next) 
    {
      
       if(!app()->auth()) {
          app()->session->setFlash('please login',session::WARNING);
          response::redirect('/login');
       }

     return $next($request);
        
    }

    
}
