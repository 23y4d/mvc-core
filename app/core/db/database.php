<?php declare(strict_types=1);

namespace app\core\db;



class database
{

    private static $inst = null;
    private static $pdo;

    private function __construct() { 
        $this->init();
    }
    private function __clone() {}

    private function init()
    {
        try {

            $defaultOptions =  [
                \PDO::ATTR_ERRMODE              => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_EMULATE_PREPARES     => false
            ];

            self::$pdo = new \PDO(
                config('db.driver'). ':host=' .config('db.host').';dbname=' . config('db.dbname'), 
                config('db.user'),
                config('db.password'),
                config('db.options') ?? $defaultOptions
            );
        } catch (\PDOException $e) {
            throw new \ErrorException($e->getMessage());
        }

        return self::$pdo;
    }

    public static function getInst(): self
    {
        return self::$inst === null ? self::$inst = new self() : self::$inst;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([self::$pdo, $name], $arguments);
    }
}
