<?php declare(strict_types=1);


namespace app\core;

use app\core\exception\notfound;
use app\core\exception\routerException;

class router
{


    protected $routes = [];

    protected $request;

    protected $preFixUrl;

    protected $middleware;


    public function __construct(request $request, middleware $middleware)
    {
        $this->request      = $request;
        $this->middleware   = $middleware;
    }



    

    public function getRoutes()
    {
        return $this->routes;
    }


    /**
     * here we wrap everting together to run 
     * @return mixed 
     */
    public function Boot()
    {

        $this->middleware->handle($this->request);
        $callBack = $this->matchUrl();
        
        if ($callBack === false) {
            throw new notfound();
        } elseif (!is_array($callBack) && is_callable($callBack)) {
            return call_user_func_array($callBack, $this->request->getParms());
        } elseif (
            is_array($callBack) &&
            class_exists($callBack[0]) &&
            method_exists($callBack[0], $callBack[1])
        ) {

            $callBack[0] = new $callBack[0]();
            return call_user_func_array($callBack, [$this->request]);
        } else {
            throw new notfound();
        }
    }





    public function add(string $path, $callBack)
    {

        $this->setRoute('get|post', $path, $callBack);
        return $this;
    }


    public function addRoutes(array $routes)
    {
        foreach ($routes as $path => $route) {
            $this->add($path, $route);
        }
    }


    public function mount(string $url, $fn)
    {
        $this->preFixUrl .= $url;
        if (is_callable($fn)) {
            call_user_func($fn);
        }
        $this->preFixUrl = null;
        return $this;
    }

    private function matchUrl()
    {

        foreach ($this->routes[$this->request->getMethod()] as $route => $callback) {
            if (!$route) continue;
            if (preg_match_all('~^' . $route . '$~', $this->request->getUri(), $m)) {
                $v = [];
                for ($i = 1; $i < count($m); $i++) {
                    $v[] = $m[$i][0];
                }
                $this->request->setParms($v);
                ///////////////////////////////   
                return $callback;
            }
        }
        return false;
    }


    public function setMiddleware(object $middleware)
    {
        $this->middleware->add($middleware);
        return $this;
    }


    private function setRoute($methods, $path, $callback)
    {    
        if($this->preFixUrl) {
            $path = $this->preFixUrl . rtrim($path,'/');
        }
        foreach (explode('|', $methods) as $method) {
            $this->routes[$method][$this->toRegex($path)] = $callback;
        }
    }


    private function toRegex($path)
    {
        return preg_replace('/\/{(.*?)}/', '/(.*?)', $path);
    }


}
