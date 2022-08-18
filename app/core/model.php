<?php declare(strict_types=1);

namespace app\core;

use app\core\classes\validate;
use app\core\interfaces\modelInterface;

abstract class Model implements modelInterface
{

    use validate;


    public function mapData($data)
    {

        foreach ((array) $data as $key => $value) {
            if (!property_exists($this, $key)) {
                continue;
            }
            $this->$key = $value;
        }
    }

    public function getLabel($attr)
    {
        return $this->labels()[$attr] ?? $attr;
    }


    public function save(bool $flag = true)
    {

        $id = static::primaryKey();
        if ($flag === false) {
            return  $this->create();
        }
        return $this->{$id} === null ? $this->create() : $this->update();
    }

    public static function getBy(array $where)
    {

        $sql  = sprintf(
            "SELECT * FROM %s WHERE %s ",
            static::table(),
            self::toSql(array_keys($where), 'AND')
        );

        $stmt = app()->db->prepare($sql);
        foreach ($where as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        $obj =  $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
        return $obj ? array_shift($obj) : false;
    }


    public static function getByPK(int $pk)
    {
        $sql = sprintf(
            "SELECT * FROM %s WHERE %s = %s ",
            static::table(),
            static::primaryKey(),
            $pk
        );
        $stmt = app()->db->prepare($sql);
        $stmt->execute();
        $obj =  $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
        return  $obj ? array_shift($obj) : false;
    }

    public static function getAll()
    {
        $table = static::table();
        $stmt = app()->db->prepare(" SELECT * FROM $table");
        if ($stmt->execute()) {
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
            return $data;
        } else {
            return false;
        }
    }

    public static function getCount()
    {

        $sql = " SELECT COUNT(*) AS c FROM " . static::table();
        $stmt = app()->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ)->c ?? 0;
    }


    private function create()
    {

        $sql = sprintf("INSERT INTO %s SET %s ",
            static::table(),
            self::toSql(static::tableSchema())
        );
        
        $stmt = app()->db->prepare($sql);
        $this->prepareValues($stmt);
        if ($stmt->execute()) {
            $id = static::primaryKey();
            $this->{$id} = (int) app()->db->lastInsertId();
            return true;
        }
        return false;
    }

    private function update()
    {

        $id = static::primaryKey();
        $sql = sprintf(
            "UPDATE  %s SET  %s  WHERE %s = %s  LIMIT 1",
            static::table(),
            self::toSql(static::tableSchema()),
            static::primaryKey(),
            $this->{$id}
        );
        $stmt = app()->db->prepare($sql);
        $this->prepareValues($stmt);
        return $stmt->execute() ?? false;
    }

    public function delete()
    {

        $id  = static::primaryKey();
        $sql = sprintf(
            "DELETE FROM %s WHERE %s = %s  LIMIT 1",
            static::table(),
            static::primaryKey(),
            $this->{$id}
        );
        $stmt = app()->db->prepare($sql);
        return $stmt->execute() ?? false;
    }


    private static function toSql($data, $with = null)
    {

        return $with === null
            ? implode(",", array_map(function ($f) {
                return "$f = :$f";
            }, $data))

            : implode(" $with ", array_map( function ($f) {
                return "$f = :$f";
            }, $data));

    }

    private function prepareValues(\PDOStatement &$stmt)
    {

        foreach (static::tableSchema() as $filedname) {
            switch ($this->{$filedname}) {
                case is_int($this->{$filedname}):
                    $param = \PDO::PARAM_INT;
                    break;
                case is_bool($this->{$filedname}):
                    $param = \PDO::PARAM_BOOL;
                     break;
                case is_string($this->{$filedname}):
                     $param = \PDO::PARAM_STR_NATL;
                 break;
                // default:
                //     $param = \PDO::PARAM_STR_NATL;
                //  break;
            }
              $stmt->bindValue(":{$filedname}", $this->{$filedname}, $param);  
        }
    }



}
