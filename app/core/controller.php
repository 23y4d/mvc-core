<?php declare(strict_types=1);
/**
 * @author Ziyad Bsiaso <zeyad.besiso@gmail.com>
 * @create at 22:53:10
 * 
 */

namespace app\core;

use app\core\middleware;

class controller
{
   
    protected $mw = [];

    public function render(string $view, array $params = [])
    {
        return view::getView($view, $params);
    }

    
    public function setlayout(string $layout)
    {
        view::setlayout($layout);
        return $this;
    }


    public function setTitle(string $title)
    {
        view::setTitle($title);
        return $this;
    }


    public function __call($name, $arguments)
    {

        if (method_exists($this, $name)) {
            if ($this->before() !== false) {
                echo call_user_func_array([$this, $name], $arguments);
            }
        }
    }

    protected function getMw()
    {
        return $this->mw;
    }

    protected function before()
    {
        (new middleware())->add($this->getMw())
            ->handle(new request);
    }
    
}
