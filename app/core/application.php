<?php declare(strict_types=1);

namespace app\core;


use app\core\db\database;
use app\core\classes\{session, response};



class application
{


   
    public $configs, $session;

    public static $app;

    public static $dir = null;

    protected static $userClass;

    protected $db, $router, $user, $middleware;

    private static $inst = null;


    private function __construct($dir)
    {
        self::$app = $this;
        self::$dir = $dir;
        $this->configs = appconfig::getInst()->watchDir(configPath());
        $this->db = database::getInst();
        $this->router = new router(new request(), new middleware());
        $this->session = new session();
        static::$userClass = $this->configs->getConfig('settings.models.user');

    }


    public static function create($dir = null): self
    {
        return self::$inst === null ? self::$inst = new self($dir) : self::$inst;
    }


    public function run()
    {

        try {
            echo $this->router->Boot();
        } catch (\Exception $e) {
            response::setStatusCode($e->getCode());
            echo view::getView('errors', [
                'error' => $e
            ]);
        }
        return $this;
    }


    public function auth()
    {

        $key = static::$userClass::primaryKey();
        $id = $this->session->get($key);
        if ($id) {
            $this->user = static::$userClass::getBy([$key => $id]);
            return $this->user;
        }
        return false;
    }


    public function add($path, $cb)
    {
        $this->router->add($path, $cb);
        return self::$inst;
    }

    public function use(...$mw)
    {
        foreach($mw as $m) {
            $this->router->setMiddleware($m);
        }
        return self::$inst;
    }

    public function setRoutes($arr)
    {
        $this->router->addRoutes($arr);
        return self::$inst;
    }

    public function mount($arr,$fn)
    {
        $this->router->mount($arr,$fn);
        return self::$inst;
    }

    public function __set($key, $object) 
    {
        if (property_exists($this, $key)) {
            $this->$key = $object;
        }
    }

    public function __get($name) 
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }


}
