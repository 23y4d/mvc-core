<?php declare(strict_types=1);

namespace app\middleware;

use app\core\classes\response;
use app\core\interfaces\middlewareInterface;

class guest implements middlewareInterface
{

    public function call($request, $next)
    {
        $has = [
            'login'   => ['/login'],
            'logout'  => ['/logout']
        ];
        if (app()->auth() && in_array($request->getUri(), $has['login'])) {
            response::redirect('/');
        } elseif (!app()->auth() && in_array($request->getUri(), $has['logout'])) {
            response::redirect('/');
        }
        return $next($request);
    }
}
