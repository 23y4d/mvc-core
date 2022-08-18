<?php declare(strict_types=1);

namespace app\core;

use app\core\exception\requsetException;

class request
{


    protected $params = [];

    protected $body;

    public function getUri()
    {
        $uri = substr($_SERVER['REQUEST_URI'], strlen($this->getBasePath()));
        if (strpos($uri, '?') !== false) {
            $uri = explode('?', $uri)[0];
        }
        return '/' . trim($uri, '/');
    }

    

    public function getBasePath()
    {
        return  implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
    }





    public function getHostUrl()
    {
        return ((isset($_SERVER['HTTPS'])) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/';
    }



    public function getMethod()
    {

        $method = $_SERVER['REQUEST_METHOD'];
        if (in_array($method, ['POST', 'GET'])) {
            return strtolower($method);
        }
        throw new requsetException('Method Not Allowed',405); die;
    }




    public function getBody()
    {
        if ($this->isGet()) {
            foreach ($_GET as $key => $value)
                $this->body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value)
                $this->body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        return $this->body;
    }



    public function isGet()
    {
        return $this->getMethod() === 'get';
    }

    public function isPost()
    {
        return $this->getMethod() === 'post';
    }




    public function setParms($parms)
    {
        $this->params = (array) $parms;
    }



    public function getParms($key = null, $type = null)
    {

        if (!is_null($key) && !is_null($type)) {
            if (array_key_exists($key, $this->params)) {
                switch (strtolower($type)) {
                    case 'int':
                        return filterInt($this->params[$key]);
                    case 'str':
                        return filterStirng($this->params[$key]);
                }
            }
        } else {
            return $this->params;
        }
    
    }


}
