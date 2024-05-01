<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces([
    'App\Models' => realpath(__DIR__ . '/../app/models/'),
    'App\Controllers' => realpath(__DIR__ . '/../app/controllers/'),
    'App\Controllers\Exceptions' => realpath(__DIR__ . '/../app/controllers/exceptions/'),
    'App\Utils' => realpath(__DIR__ . '/../app/utils/'),
    'App\Middlewares' => realpath(__DIR__ . '/../app/middlewares/')
]);

$loader->register();
