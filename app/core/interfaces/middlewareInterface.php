<?php declare(strict_types=1);

namespace app\core\interfaces;


interface middlewareInterface
{
    public function call(object $request, callable $next); 
}