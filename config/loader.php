<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces([
    'App\Models' => realpath(__DIR__ . '/../app/models/'),
    'App\Controllers' => realpath(__DIR__ . '/../app/controllers/'),
    'App\Services' => realpath(__DIR__ . '/../app/services'),
]);

$loader->register();
