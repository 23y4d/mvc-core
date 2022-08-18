<?php declare(strict_types=1);

namespace app\core;

use app\core\interfaces\middlewareInterface;

class middleware
{

    protected $start;

    protected $mw = [];

    public function __construct()
    {
        $this->start = fn ($r) => $r;
    }

    public function add($middlewares)
    {

        if (is_array($middlewares)) {
            foreach ($middlewares as $k => $mw) {
                $this->mw[] = new $mw;
            }
        } elseif (is_object($middlewares)) {
            if (!$middlewares instanceof middlewareInterface) {
                throw new \Exception(
                    get_class($middlewares) . 'is not a valid middleware'
                );
            }
            $next = $this->start;
            $this->start = function ($request) use ($middlewares, $next) {
                return $middlewares->call($request, $next);
            };
        }
        return $this;
    }


    public function handle($request)
    {
        if (count($this->mw) > 0) {
            $this->handleArray($request);
        }
        call_user_func($this->start, $request);
    }


    private function handleArray($request)
    {
        $next = $this->start;
        for ($i = 0; $i < count($this->mw); $i++) {
            $middleware = $this->mw[$i];
            if (!$middleware instanceof middlewareInterface) {
                throw new \Exception(
                    get_class($middleware) . 'is not a valid middleware'
                );
            }
            call_user_func_array([$middleware, 'call'], [$request, $next]);
        }
    }

    
}
