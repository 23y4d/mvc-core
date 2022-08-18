<?php declare(strict_types=1);

namespace app\core\interfaces;


interface modelInterface
{

     public function rules(): array;

     public function labels(): array;

     public static function primaryKey(): string;

     public static function table(): string;

     public static function tableSchema(): array;

}