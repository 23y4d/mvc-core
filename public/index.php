<?php declare(strict_types=1);

require_once  __DIR__ . '/../vendor/autoload.php';

require_once  __DIR__ . '/../app/core/classes/helpers.php';

use app\core\application;
use app\middleware\{erorrs};

application::create(__DIR__)
                ->use(new erorrs)
                ->setRoutes(config('routes'))   
                ->run();
