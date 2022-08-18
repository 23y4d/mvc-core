<?php

return [

    '/hello/{name}'                => fn($name) => "hello {$name}",
    '/'                            => [app\controllers\sitecontroller::class,'index'],
    '/home/{name}'                 => [app\controllers\sitecontroller::class,'home'],

];