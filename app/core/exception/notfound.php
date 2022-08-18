<?php declare(strict_types=1); 

namespace app\core\exception;


class NotFound extends \Exception
{
    protected $message = 'NOT FOUND';
    protected $code = 404;
}

?>