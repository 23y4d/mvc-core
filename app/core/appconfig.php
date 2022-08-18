<?php declare(strict_types=1);

namespace app\core;


class appconfig 
{

    protected static $inst = null;
    private $arr = [];

    private function __construct() {}

    public static function getInst() : self  
    {
        return self::$inst === null ? self::$inst = new self() : self::$inst;
    }

    public function watchDir($path)
    {

        if (!is_dir($path)) {
            throw new \LogicException("couldn't load files from {$path} please chack your config files ", 500);
        }
        foreach (scandir($path) as $file) {
            $arr = [];
            if ($file != '.' && $file != '..') {
                $filename = explode('.', $file)[0];
                $arr = [$filename => require $path . $file];
                foreach ($arr as $key => $value) {
                    $this->arr[$key] = $value;
                }
            }
        }
        return $this;
    }


    public function getConfig($key)
    {
        return self::get($this->arr, $key);
    }

    public function setConfig($key,$value)
    {
        return self::set($this->arr,$key,$value);
    }


    private static function get($array, $key)
    {
		if (isset($array[$key])) { 
            return $array[$key];
        }
        foreach (explode('.', $key) as $k) {
            if (!is_array($array) || !array_key_exists($k, $array)) {
                return false;   
            }
            $array = $array[$k];
        }
		return $array;
    }

    private static function set(&$array, $key, $value)
    {
        if (is_null($key)) return $array = $value;
        $keys = explode('.', $key);
        while (count($keys) > 1) {
            $key = array_shift($keys);
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;
    }
    

}
